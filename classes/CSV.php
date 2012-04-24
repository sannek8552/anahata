<?php

class CSV {
    
    function getCsv($dataArray,$delimiter=",",$enclosure="\"") {	         
        // Build the string
        $string = "";
    
        // for each array element, which represents a line in the csv file...
        foreach($dataArray as $line){
            // No leading delimiter
            $writeDelimiter = FALSE;
    
            foreach($line as $dataElement){ 
                // Replaces a double quote with two double quotes
                $dataElement=str_replace("\"", "\"\"", $dataElement);
                $dataElement=str_replace("\n", "", $dataElement);
                $dataElement=str_replace("\r", "", $dataElement);
                
                // Adds a delimiter before each field (except the first)
                if($writeDelimiter) $string .= $delimiter;
                                                                                                
                // Encloses each field with $enclosure and adds it to the string
                $string .= $enclosure . $dataElement . $enclosure;
    
                // Delimiters are used every time except the first.
                $writeDelimiter = TRUE;
            }
            // Append new line
            $string .= "\r\n";    
        } // end foreach($dataArray as $line)    
        return $string;
    }
    
     function getCsvFile($dataArray,$delimiter=",",$enclosure="\"",$filename) {	         
        // Build the string    
        
        $fh = fopen("smarty/templates_c/{$filename}.csv","a");
        // for each array element, which represents a line in the csv file...
        foreach($dataArray as $line){
            $string = "";
            // No leading delimiter
            $writeDelimiter = FALSE;
    
            foreach($line as $dataElement){ 
                // Replaces a double quote with two double quotes
                $dataElement=str_replace("\"", "\"\"", $dataElement);
                $dataElement=str_replace("\n", "", $dataElement);
                $dataElement=str_replace("\r", "", $dataElement);
                
                // Adds a delimiter before each field (except the first)
                if($writeDelimiter) $string .= $delimiter;
                                                                                                
                // Encloses each field with $enclosure and adds it to the string
                $string .= $enclosure . $dataElement . $enclosure;
    
                // Delimiters are used every time except the first.
                $writeDelimiter = TRUE;
            }
            // Append new line
            $string .= "\n";    
            fwrite($fh,$string);
        } // end foreach($dataArray as $line)
        fclose($fh);
        return $filename;
    }
    
    function getCsvFile_grobokop($dataArray,$filename,$delimiter=",",$enclosure="\"") {	         
        // Build the string    
        
        $fh = fopen("{$filename}.csv","w");
        // for each array element, which represents a line in the csv file...
        foreach($dataArray as $line){
            $string = "";
            // No leading delimiter
            $writeDelimiter = FALSE;
    
            foreach($line as $dataElement){ 
                // Replaces a double quote with two double quotes
                $dataElement=str_replace("\"", "\"\"", $dataElement);
                $dataElement=str_replace("\n", "", $dataElement);
                $dataElement=str_replace("\r", "", $dataElement);
                
                // Adds a delimiter before each field (except the first)
                if($writeDelimiter) $string .= $delimiter;
                                                                                                
                // Encloses each field with $enclosure and adds it to the string
                $string .= $enclosure . $dataElement . $enclosure;
    
                // Delimiters are used every time except the first.
                $writeDelimiter = TRUE;
            }
            // Append new line
            $string .= "\n";    
            fwrite($fh,$string);
        } // end foreach($dataArray as $line)
        fclose($fh);
        return $filename;
    }
    function parseCSV($filename, $delimiter=",", $enclosure="\"",$withheader='1', $titles=array()) {
        $result = array();
        $lines = file($filename);
        foreach ($lines as $line) {
            $result[] = explode($delimiter,$line);
        }
        if ($withheader) unset($result[0]);
        $fl_title = count($titles);
        $regex = "/^{$enclosure}|{$enclosure}$/";
        $data = array();
        
        foreach ($result as $key => $value) {
            foreach ($value as $k => $v) {
				$i = $fl_title ? $titles[$k] : $k;
                //$result[$key][$i] = preg_replace($regex, "", trim($v));
                $data[$key][$i]= preg_replace($regex, "", trim($v));
            }
        }
        
        return $data;
    }
    
    function ParseFromString($content, $delimiter=",", $enclosure="\"",$withheader='1'){
        $data = array();
#        $content = iconv($this->inputEncoding, $this->outputEncoding, $content );
        $content = str_replace( "\r\n", "\n", $content );
        $content = str_replace( "\r", "\n", $content );
        #if ( $hasBOM )                                // Remove the BOM (first 3 bytes)
        #{
         #   $content = substr( $content, 3 );
        #}
        if ( $content[strlen($content)-1] != "\n" )   // Make sure it always end with a newline
        {
            $content .= "\n";
        }

        // Parse the content character by character
        $row = array( "" );
        $idx = 0;
        $quoted = false;
        for ( $i = 0; $i < strlen($content); $i++ )
        {
            $ch = $content[$i];
            if ( $ch == $enclosure )
            {
                $quoted = !$quoted;
            }

            // End of line
            if ( $ch == "\n" && !$quoted )
            {
                // Remove enclosure delimiters
                for ( $k = 0; $k < count($row); $k++ )
                {
                    if ( $row[$k] != "" && $row[$k][0] == $enclosure )
                    {
                        $row[$k] = substr( $row[$k], 1, strlen($row[$k]) - 2 );
                    }
                    $row[$k] = str_replace( str_repeat($enclosure, 2), $enclosure, $row[$k] );
                }

                // Append row into table
                $data[] = $row;
                $row = array( "" );
                $idx = 0;
            }

            // End of field
            else if ( $ch == $delimiter && !$quoted )
            {
                $row[++$idx] = "";
            }

            // Inside the field
            else
            {
                $row[$idx] .= $ch;
            }
        }
        #var_dump($data);
        return $data;
    }
}

?>