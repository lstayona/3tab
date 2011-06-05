<?php
pake_desc('3tab import csv all');
pake_task('3tab-import-csv-all');

pake_desc('3tab import csv specific');
pake_task('3tab-import-csv-specific');

function run_3tab_import_csv_all($task, $args)
{
    define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
    define('SF_APP',         '3tab');
    define('SF_ENVIRONMENT', 'dev');
    define('SF_DEBUG',       true);
    require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
    sfContext::getInstance();
    
    $update = false;
    if(in_array("update", $args))
    {
        $update = true;
    }
    
    if(is_dir(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'tournament'))
    {
        // Get all folders in the tournament directory
        foreach(scandir(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'tournament') as $institutionFolder)
        {
            // Filter out anything that starts with a .
            if(is_dir(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'tournament'.DIRECTORY_SEPARATOR.$institutionFolder) 
              and substr($institutionFolder, 0, 1) != '.')
            {
                echo "Importing from folder: " . sfConfig::get('sf_data_dir') . 
                DIRECTORY_SEPARATOR . 'tournament' . DIRECTORY_SEPARATOR . 
                $institutionFolder . "\n";
                foreach(array('Institution', 'Team', 'Debater', 'Adjudicator') as $model)
                {
                    if(is_file(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'tournament'.DIRECTORY_SEPARATOR.$institutionFolder.DIRECTORY_SEPARATOR.sfInflector::underscore($model) . '.csv'))
                    {
                        echo "Importing $model from file: " . sfConfig::get('sf_data_dir') . 
                        DIRECTORY_SEPARATOR.'tournament'.DIRECTORY_SEPARATOR.
                        $institutionFolder.DIRECTORY_SEPARATOR.sfInflector::underscore($model) . ".csv\n";
                        
                        import_csv_file($model, $institutionFolder, $update);
                    }
                }
            }
        }
    }
}

function run_3tab_import_csv_specific($task, $args)
{
    define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
    define('SF_APP',         '3tab');
    define('SF_ENVIRONMENT', 'dev');
    define('SF_DEBUG',       true);
    require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
    sfContext::getInstance();
    
    $update = false;
    if(in_array("update", $args))
    {
        $update = true;
    }
    
    $institutionFolder = "";
    if(in_array("institution", $args))
    {
        $institutionArgIndex = array_search("institution", $args);
        if(isset($args[$institutionArgIndex + 1]))
        {
            $institutionFolder = $args[$institutionArgIndex + 1];
        }
        else
        {
            throw new Exception("No institution folder specified");
        }
    }
    
    if(is_dir(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'tournament'.DIRECTORY_SEPARATOR.$institutionFolder))
    {
        echo "Importing from folder: " . sfConfig::get('sf_data_dir') . 
        DIRECTORY_SEPARATOR . 'tournament' . DIRECTORY_SEPARATOR . 
        $institutionFolder . "\n";
        foreach(array('Institution', 'Team', 'Debater', 'Adjudicator') as $model)
        {
            if(is_file(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'tournament'.DIRECTORY_SEPARATOR.$institutionFolder.DIRECTORY_SEPARATOR.sfInflector::underscore($model) . '.csv'))
            {
                echo "Importing $model from file: " . sfConfig::get('sf_data_dir') . 
                DIRECTORY_SEPARATOR.'tournament'.DIRECTORY_SEPARATOR.
                $institutionFolder.DIRECTORY_SEPARATOR.sfInflector::underscore($model) . ".csv\n";
                
                import_csv_file($model, $institutionFolder, $update);
            }
        }
    }
}

function import_csv_file($model, $institutionFolder, $update = false)
{
    $ignoredCount = 0;
    $updatedCount = 0;
    $insertedCount = 0;
    $propelConn = Propel::getConnection();
    try
    {
        $propelConn->begin();
        $contents = sfCsv::load(sfConfig::get('sf_data_dir') . 
        DIRECTORY_SEPARATOR.'tournament'.DIRECTORY_SEPARATOR.
        $institutionFolder.DIRECTORY_SEPARATOR.sfInflector::underscore($model) . ".csv");
        foreach($contents as $number => $row)
        {
            $obj = null;
            $exists = false;
            
            if($model == 'Institution')
            {
                list($exists, $obj) = InstitutionPeer::createFromCSVLine($row, $number, $contents, $update, $propelConn);
            }
            else if($model == 'Team')
            {
                list($exists, $obj) = TeamPeer::createFromCSVLine($row, $number, $contents, $update, $propelConn);
            }
            else if($model == 'Debater')
            {
                list($exists, $obj) = DebaterPeer::createFromCSVLine($row, $number, $contents, $update, $propelConn);
            }
            else if($model == 'Adjudicator')
            {
                list($exists, $obj) = AdjudicatorPeer::createFromCSVLine($row, $number, $contents, $update, $propelConn);
            }
            else
            {
                throw new Exception("Model '" . $model . "' is not supported.");
            }
            
            if($update and $exists)
            {
                $updatedCount++;
                $obj->save($propelConn);
            }
            else if(!$update and $exists)
            {
                $ignoredCount++;
            }
            else if(!$exists and ($update or !$update))
            {
                $insertedCount++;
                $obj->save($propelConn);
            }
        }
        
        $propelConn->commit();
        echo "$institutionFolder -> $model -> Inserted $insertedCount row(s).  Updated $updatedCount row(s).  Ignored $ignoredCount row(s).\n";
    }
    catch(Exception $e)
    {
        $propelConn->rollback();
        die("The following error occured on line number " . ($number + 2) . " with contents " . print_r($row, true) . ": " . $e->getMessage());
    }
}
?>
