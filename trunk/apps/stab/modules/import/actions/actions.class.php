<?php

/**
 * import actions.
 *
 * @package    stab
 * @subpackage import
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class importActions extends sfActions
{
   /**
    * Executes index action
    *
    */
    public function executeIndex()
    {
        return sfView::SUCCESS;
    }
    
    public function executeImport()
    {
        $fileUploaded = false;
        
        if (strlen($this->getRequest()->getFilePath('csv_file')) > 0)
        {
            foreach ($this->getRequest()->getFileNames() as $inputName)
            {
            	$realFileName =  $this->getRequest()->getFileName($inputName);
            	if ($this->getRequest()->getFileSize($inputName) > 0) 
            	{ 			
                	$pathPathItems = pathinfo($realFileName);
                	if (strtolower($pathPathItems['extension']) != 'csv')
                	{
                		$this->getRequest()->setError('not_a_csv_file', $pathPathItems['basename'] . " is not a csv file.");
                	}
                	
		    $this->getRequest()->moveFile($inputName, sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . $realFileName);
                    $fileUploaded = true;
            	}
            }
        }

        if(!$fileUploaded)
        {
            throw new Exception("Error in file upload.");
        }

        $ignoredCount = 0;
        $updatedCount = 0;
        $insertedCount = 0;
        
        $propelConn = Propel::getConnection();
        try
        {
            $propelConn->begin();
            $contents = sfCsv::load(sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . $realFileName);
            foreach($contents as $number => $row)
            {
                $obj = null;
                $exists = false;
                
                if($this->getRequestParameter('target_model') == 'Institution')
                {
                    list($exists, $obj) = InstitutionPeer::createFromCSVLine($row, $number, $contents, $this->getRequestParameter("update", false), $propelConn);
                }
                else if($this->getRequestParameter('target_model') == 'Team')
                {
                    list($exists, $obj) = TeamPeer::createFromCSVLine($row, $number, $contents, $this->getRequestParameter("update", false), $propelConn);
                }
                else if($this->getRequestParameter('target_model') == 'Debater')
                {
                    list($exists, $obj) = DebaterPeer::createFromCSVLine($row, $number, $contents, $this->getRequestParameter("update", false), $propelConn);
                }
                else if($this->getRequestParameter('target_model') == 'Adjudicator')
                {
                    list($exists, $obj) = AdjudicatorPeer::createFromCSVLine($row, $number, $contents, $this->getRequestParameter("update", false), $propelConn);
                }
                else if($this->getRequestParameter('target_model') == 'Venue')
                {
                    list($exists, $obj) = VenuePeer::createFromCSVLine($row, $number, $contents, $this->getRequestParameter("update", false), $propelConn);
                }
                else
                {
                    throw new Exception("Model '" . $this->getRequestParameter('target_model') . "' is not supported.");
                }
                
                if($this->getRequestParameter("update", false) and $exists)
                {
                    $updatedCount++;
                    $obj->save($propelConn);
                }
                else if(!$this->getRequestParameter("update", false) and $exists)
                {
                    $ignoredCount++;
                }
                else if(!$exists and ($this->getRequestParameter("update", false) or !$this->getRequestParameter("update", false)))
                {
                    $insertedCount++;
                    $obj->save($propelConn);
                }
            }
            
            $propelConn->commit();
            unlink(sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . $realFileName);
        }
        catch(Exception $e)
        {
            $propelConn->rollback();
            unlink(sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . $realFileName);
            throw new Exception("The following error occured on line number " . ($number + 2) . ": " . $e->getMessage());
        }
        
        $this->getRequest()->setParameter("messages", array($this->getRequestParameter('target_model') . " import: $insertedCount row(s) inserted.  $updatedCount row(s) updated. $ignoredCount row(s) ignored."));
        
        $this->forward("import", "index");
    }
}
