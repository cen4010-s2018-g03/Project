<?php
 
 
 //connect to db
		$mysqli = NEW MySQLi("localhost", "CEN4010_S2018g03", "cen4010_s2018", "CEN4010_S2018g03");

		if (!$mysqli->query("call pr_export_inventory")) {
			echo "pr_export_inventory failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		else{
			$DB_Server = "localhost"; //MySQL Server    
			$DB_Username = "CEN4010_S2018g03"; //MySQL Username     
			$DB_Password = "cen4010_s2018";             //MySQL Password     
			$DB_DBName = "CEN4010_S2018g03";         //MySQL Database Name  
			$DB_TBLName = "Import_Inventory"; //MySQL Table Name   
			$filename = "export_inventory";         //File Name
  
//create MySQL connection   
			$sql = "Select * from $DB_TBLName";
			//$Connect = NEW MySQLi($DB_Server, $DB_Username, $DB_Password) or die("Couldn't connect to MySQL:<br>" . mysqli_error() . "<br>" . mysqli_errno());
			$Connect = $mysqli;
			//$Connect = NEW MySQLi($DB_Server, $DB_Username, $DB_Password);
//select database   
			//$Db = @mysqli_select_db($DB_DBName, $Connect) or die("Couldn't select database:<br>" . mysqli_error($Connect). "<br>" . mysqli_errno($Connect)); 
			$Db = @mysqli_select_db($Connect, $DB_DBName) or die("Couldn't select database:<br>" . mysqli_error($Connect). "<br>" . mysqli_errno($Connect));
			//$Db = @mysqli_select_db($DB_DBName, $Connect);
//execute query 
			$result = @mysqli_query($Connect,$sql) or die("Couldn't execute query:<br>" . mysqli_error($Connect). "<br>" . mysqli_errno($Connect)); 
			//$result = @mysqli_query($sql,$Connect);
			$file_ending = "xls";
//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
			$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
			for ($i = 0; $i < mysqli_num_fields($result); $i++) {
				//echo mysql_field_name($result,$i) . "\t";
				$info_field=mysqli_fetch_field_direct($result,$i);
				echo $info_field->name . "\t";
			}
			print("\n");    
//end of printing column names  
//start while loop to get data
    while($row = mysqli_fetch_row($result))
    {
        $schema_insert = "";
        for($j=0; $j<mysqli_num_fields($result);$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    }   
		}
 
 ?>