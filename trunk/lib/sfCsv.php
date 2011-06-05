<?php
class sfCsv
{
    public static function load($input)
    { 
        $data_array = array();
        $header_array = array();
        
        if(!file_exists($input) or !is_readable($input))
        {
            throw new Exception($input.' is unreadable or does not exist.');
        }
         
        $handle = fopen($input, "r");
        
        if(($first_row = fgetcsv($handle)) !== FALSE)
        {
            $header_array = array_map('trim', $first_row);
        }
        
        $current_row = 0;
        
        while (($data = fgetcsv($handle)) !== FALSE) 
        {
            for($walker = 0; $walker < count($header_array); $walker++)
            {
                try
                {
                    $val = null;
                    if(isset($data[$walker]))
                    {
                        $val = trim($data[$walker]);
                        
                        if(in_array(strtolower($val), array('null', '', '~')))
                        {
                            $val = null;
                        }
                        else if((string)$val === (string)(int)$val)
                        {
                            $val = (int)$val;
                        }
                        else if(is_numeric($val) and (string)$val === (string)(float)$val)
                        {
                            $val = (float)$val;
                        }
                        else if(in_array(strtolower($val), array('true')))
                        {
                            $val = TRUE;
                        }
                        else if(in_array(strtolower($val), array('false')))
                        {
                            $val = FALSE;
                        }
                    }
                    
                    $data_array[$current_row][$header_array[$walker]] = $val;
                }
                catch(Exception $e)
                {
                    throw $e;
                }
            }
            
            $current_row++;
        }
        
        fclose($handle);
        
        return count($data_array) ? $data_array : array();
    }
}
?>