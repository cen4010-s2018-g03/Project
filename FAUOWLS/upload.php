<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$target_file = $target_dir . "export_inventory.csv";
$uploadOk = 1;
//echo "$target_file";
// Check if $uploadOk is set to 0 by an error

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		//connect to db
	/*
		$mysqli = NEW MySQLi("localhost", "CEN4010_S2018g03", "cen4010_s2018", "CEN4010_S2018g03");
		
		if (!$mysqli->query("TRUNCATE TABLE Import_Inventory")) {
			echo "TRUNCATE failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

		$result = $mysqli->query("LOAD DATA LOCAL INFILE ".$target_file." INTO TABLE Import_Inventory FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' IGNORE 1 LINES");
		if (!$mysqli->query("CALL pr_import_inventory()")) {
			echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		else{
			if(!$mysqli->query("SET @result = 0") || !$mysqli->query("CALL pr_import_inventory(@result)")) {
				echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			else{
				if(@result==0){
					echo "Successful Import";
				}
				else{
					echo"Unsuccessful Import";
				}
			}
		}
		*/
		/*
		$row = 1;
		if (($handle = fopen($target_file, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				echo "<p> $num fields in line $row: <br /></p>\n";
				$row++;
				for ($c=0; $c < $num; $c++) {
					echo $data[$c] . "<br />\n";
				}
			}
		fclose($handle);
		}
    } 
	else {
        echo "Sorry, there was an error uploading your file.";
    }
	*/
	//Connect to Database and import file data into Import_Inventory table
	$db = NEW MySQLi("localhost", "CEN4010_S2018g03", "cen4010_s2018", "CEN4010_S2018g03") or die("Couldn't connect to database:<br>" . mysqli_error($db). "<br>" . mysqli_errno($db));
	

	if(!mysqli_select_db($db,"CEN4010_S2018g03"))

		die("Couldn't select database:<br>" . mysqli_error($db). "<br>" . mysqli_errno($db));
	
	if (!$db->query("TRUNCATE TABLE Import_Inventory")) {
		echo "TRUNCATE failed: (" . $db->errno . ") " . $db->error;
	}

	$filename=$target_file;
	
	$handle = fopen($filename, 'r');

	$first = 0;

	while (($data = fgetcsv($handle, 1000, ',')) !== FALSE){
		if ($first==0){
			$first =1;
		}
		else{
			//echo "Dato $data[17]";
			for($i = sizeof($data); $i <22;$i++)
			{
				$data[$i] = "";
			}

			$import="INSERT into Import_Inventory(perry_part_num, short_description, long_description, location_in_lab, quantity, purchase_or_rent, retail_price, retail_price_promo,retail_markup,jobber_price,jobber_markup,bulk_price,bulk_markup,cost_to_replace,cost_avg,category_code,category_name,barcode1,barcode2,barcode3,barcode4,barcode5) 
			values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','$data[17]','$data[18]','$data[19]','$data[20]','$data[21]')";

			$db->query($import) or die(mysqli_error($db));
		}

	}

	fclose($handle);
	//call procedure that moves data from Import_Inventory table to Inventory table
	//$res=0;
	$db->query("CALL pr_import_inventory(@res)") or die(mysqli_error($db));
	/*if($res!=0){
		print "Error with pr_import_inventory procedure";
	}
	else{
		print "Import done";
	}
	*/
	print "Import done";
	}
}
?>