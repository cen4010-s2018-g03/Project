<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Update a Record - PHP CRUD Tutorial</title>
     
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
         
</head>
<body>
 
    <!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Update Inventory Item #<?php echo isset($_GET['perry_part_num'])?$_GET['perry_part_num']:die('ERROR: Record ID not found.');?></h1>
        </div>
     
        <!-- PHP read record by ID will be here -->
		<?php
			// get passed parameter value, in this case, the record ID
			// isset() is a PHP function used to verify if a value is there or not
			$perry_part_num=isset($_GET['perry_part_num']) ? $_GET['perry_part_num'] : die('ERROR: Record ID not found.');
			
			//include database connection
			include 'config/database.php';
			
			// read current record's data
			try {
				// prepare select query
				$query = "SELECT "
					."perry_part_num, "
					."short_description, "
					."long_description, "
					."location_in_lab, "
					."quantity, "
					."purchase_or_rent, "
					."retail_price, "
					."retail_price_promo, "
					."retail_markup, "
					."jobber_price, "
					."jobber_markup, "
					."bulk_price, "
					."bulk_markup, "
					."cost_to_replace, "
					."cost_avg, "
					."category_code "
					."FROM Inventory WHERE perry_part_num = ? LIMIT 0,1";
				$stmt = $con->prepare( $query );
				
				// this is the first question mark
				$stmt->bindParam(1, $perry_part_num);
				
				// execute our query
				$stmt->execute();
				
				// store retrieved row to a variable
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				
				// values to fill up our form				
				//$perry_part_num=$row['perry_part_num'];
				$short_description=$row['short_description'];
				$long_description=$row['long_description'];
				$location_in_lab=$row['location_in_lab'];
				$quantity=$row['quantity'];
				$purchase_or_rent=$row['purchase_or_rent'];
				$retail_price=$row['retail_price'];
				$retail_price_promo=$row['retail_price_promo'];
				$retail_markup=$row['retail_markup'];
				$jobber_price=$row['jobber_price'];
				$jobber_markup=$row['jobber_markup'];
				$bulk_price=$row['bulk_price'];
				$bulk_markup=$row['bulk_markup'];
				$cost_to_replace=$row['cost_to_replace'];
				$cost_avg=$row['cost_avg'];
				$category_code=$row['category_code'];
			}
				
				// show error
				catch(PDOException $exception){
				die('ERROR: ' . $exception->getMessage());
			}
		?>
		
        <!-- HTML form to update record will be here -->
		<!-- PHP post to update record will be here -->
		<?php
 
			// check if form was submitted
			if($_POST){
				
				try{
					
					// write update query
					// in this case, it seemed like we have so many fields to pass and 
					// it is better to label them and not use question marks
					$query = "UPDATE Inventory "
						."SET "
						."short_description=:short_description, "
						."long_description=:long_description, "
						."location_in_lab=:location_in_lab, "
						."quantity=:quantity, "
						."purchase_or_rent=:purchase_or_rent, "
						."retail_price=:retail_price, "
						."retail_price_promo=:retail_price_promo, "
						."retail_markup=:retail_markup, "
						."jobber_price=:jobber_price, "
						."jobber_markup=:jobber_markup, "
						."bulk_price=:bulk_price, "
						."bulk_markup=:bulk_markup, "
						."cost_to_replace=:cost_to_replace, "
						."cost_avg=:cost_avg, "
						."category_code=:category_code "
						."WHERE perry_part_num=:perry_part_num";
 
					// prepare query for execution
					$stmt = $con->prepare($query);
					
					// posted values
					//$perry_part_num=htmlspecialchars(strip_tags($_POST['perry_part_num']));
					$short_description=htmlspecialchars(strip_tags($_POST['short_description']));
					$long_description=htmlspecialchars(strip_tags($_POST['long_description']));
					$location_in_lab=htmlspecialchars(strip_tags($_POST['location_in_lab']));
					$quantity=htmlspecialchars(strip_tags($_POST['quantity']));
					$purchase_or_rent=htmlspecialchars(strip_tags($_POST['purchase_or_rent']));
					$retail_price=htmlspecialchars(strip_tags($_POST['retail_price']));
					$retail_price_promo=htmlspecialchars(strip_tags($_POST['retail_price_promo']));
					$retail_markup=htmlspecialchars(strip_tags($_POST['retail_markup']));
					$jobber_price=htmlspecialchars(strip_tags($_POST['jobber_price']));
					$jobber_markup=htmlspecialchars(strip_tags($_POST['jobber_markup']));
					$bulk_price=htmlspecialchars(strip_tags($_POST['bulk_price']));
					$bulk_markup=htmlspecialchars(strip_tags($_POST['bulk_markup']));
					$cost_to_replace=htmlspecialchars(strip_tags($_POST['cost_to_replace']));
					$cost_avg=htmlspecialchars(strip_tags($_POST['cost_avg']));
					$category_code=htmlspecialchars(strip_tags($_POST['category_code']));
					
					// bind the parameters
					//$stmt->bindParam(':id', $id);
					$stmt->bindParam(':perry_part_num', $perry_part_num);
					$stmt->bindParam(':short_description', $short_description);
					$stmt->bindParam(':long_description', $long_description);
					$stmt->bindParam(':location_in_lab', $location_in_lab);
					$stmt->bindParam(':quantity', $quantity);
					$stmt->bindParam(':purchase_or_rent', $purchase_or_rent);
					$stmt->bindParam(':retail_price', $retail_price);
					$stmt->bindParam(':retail_price_promo', $retail_price_promo);
					$stmt->bindParam(':retail_markup', $retail_markup);
					$stmt->bindParam(':jobber_price', $jobber_price);
					$stmt->bindParam(':jobber_markup', $jobber_markup);
					$stmt->bindParam(':bulk_price', $bulk_price);
					$stmt->bindParam(':bulk_markup', $bulk_markup);
					$stmt->bindParam(':cost_to_replace', $cost_to_replace);
					$stmt->bindParam(':cost_avg', $cost_avg);
					$stmt->bindParam(':category_code', $category_code);
					
					// Execute the query
					if($stmt->execute()){
						echo "<div class='alert alert-success'>Record was updated.</div>";
					}else{
						echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
					}
         
				}
     
				// show errors
				catch(PDOException $exception){
					die('ERROR: ' . $exception->getMessage());
				}
			}
		?>
 
		<!--we have our html form here where new record information can be updated-->
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?perry_part_num={$perry_part_num}");?>" method="post">
			<table class='table table-hover table-responsive table-bordered'>
				<!--
				<tr>
					<td>Perry part no.</td>
					<td><input type='text' name='perry_part_num' value="<#?php echo htmlspecialchars($perry_part_num, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				-->
				<tr>
					<td>Short desc.</td>
					<td><input type='text' name='short_description' value="<?php echo htmlspecialchars($short_description, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Long desc.</td>
					<td><textarea name='long_description' class='form-control'><?php echo htmlspecialchars($long_description, ENT_QUOTES);  ?></textarea></td>
				</tr>
				<tr>
					<td>Loc. in lab</td>
					<td><input type='text' name='location_in_lab' value="<?php echo htmlspecialchars($location_in_lab, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Quantity</td>
					<td><input type='text' name='quantity' value="<?php echo htmlspecialchars($quantity, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Purch./rent</td>
					<td><input type='text' name='purchase_or_rent' value="<?php echo htmlspecialchars($purchase_or_rent, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Retail $</td>
					<td><input type='text' name='retail_price' value="<?php echo htmlspecialchars($retail_price, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>	
				<tr>
					<td>Retail promo $</td>
					<td><input type='text' name='retail_price_promo' value="<?php echo htmlspecialchars($retail_price_promo, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Retail markup</td>
					<td><input type='text' name='retail_markup' value="<?php echo htmlspecialchars($retail_markup, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Jobber $</td>
					<td><input type='text' name='jobber_price' value="<?php echo htmlspecialchars($jobber_price, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Jobber markup</td>
					<td><input type='text' name='jobber_markup' value="<?php echo htmlspecialchars($jobber_markup, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Bulk $</td>
					<td><input type='text' name='bulk_price' value="<?php echo htmlspecialchars($bulk_price, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Bulk markup</td>
					<td><input type='text' name='bulk_markup' value="<?php echo htmlspecialchars($bulk_markup, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Cost to replace</td>
					<td><input type='text' name='cost_to_replace' value="<?php echo htmlspecialchars($cost_to_replace, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Avg. cost</td>
					<td><input type='text' name='cost_avg' value="<?php echo htmlspecialchars($cost_avg, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
				<tr>
					<td>Cat. code</td>
					<td><input type='text' name='category_code' value="<?php echo htmlspecialchars($category_code, ENT_QUOTES);  ?>" class='form-control'/></td>
				</tr>
					
				<tr>
					<td></td>
					<td>
						<input type='submit' value='Save Changes' class='btn btn-primary' />
						<a href='index.php' class='btn btn-danger'>Return to inventory table</a>
					</td>
				</tr>
			</table>
		</form>
				
    </div> <!-- end .container -->
     
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</body>
</html>