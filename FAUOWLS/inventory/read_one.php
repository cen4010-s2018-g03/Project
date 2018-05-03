<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
 
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
 
</head>
<body>
 
 
    <!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Read Inventory Item #<?php echo isset($_GET['perry_part_num'])?$_GET['perry_part_num']:die('ERROR: Record ID not found.');?></h1>
        </div>
         
        <!-- PHP read one record will be here -->
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
		
        <!-- HTML read one record table will be here -->
		<!--we have our html table here where the record will be displayed-->
		<table class='table table-hover table-responsive table-bordered'>
			
			<tr>
				<td>Perry part no.</td>
				<td><?php echo htmlspecialchars($perry_part_num, ENT_QUOTES);  ?></td>
			</tr>
			
			<tr>
				<td>Short desc.</td>
				<td><?php echo htmlspecialchars($short_description, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Long desc.</td>
				<td><?php echo htmlspecialchars($long_description, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Loc. in lab</td>
				<td><?php echo htmlspecialchars($location_in_lab, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><?php echo htmlspecialchars($quantity, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Purch./rent</td>
				<td><?php echo htmlspecialchars($purchase_or_rent, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Retail $</td>
				<td><?php echo htmlspecialchars($retail_price, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Retail promo $</td>
				<td><?php echo htmlspecialchars($retail_price_promo, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Retail markup</td>
				<td><?php echo htmlspecialchars($retail_markup, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Jobber $</td>
				<td><?php echo htmlspecialchars($jobber_price, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Jobber markup</td>
				<td><?php echo htmlspecialchars($jobber_markup, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Bulk $</td>
				<td><?php echo htmlspecialchars($bulk_price, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Bulk markup</td>
				<td><?php echo htmlspecialchars($bulk_markup, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Cost to replace</td>
				<td><?php echo htmlspecialchars($cost_to_replace, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Avg. cost</td>
				<td><?php echo htmlspecialchars($cost_avg, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td>Cat. code</td>
				<td><?php echo htmlspecialchars($category_code, ENT_QUOTES);  ?></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<a href='index.php' class='btn btn-danger'>Return to inventory table</a>
				</td>
			</tr>
		</table>
		
    </div> <!-- end .container -->
     
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</body>
</html>