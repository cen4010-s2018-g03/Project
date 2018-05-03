<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
      
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
          
</head>
<body>
  
    <!-- container -->
    <div class="container">
   
        <div class="page-header">
            <h1>Create New Item</h1>
        </div>
      
    <!-- html form to create product will be here -->
	<!-- PHP insert code will be here -->
	<?php
if($_POST){
 
    // include database connection
    include 'config/database.php';
 
    try{
     
        // insert query
        $query = "INSERT INTO Inventory "
			."SET perry_part_num=:perry_part_num, "
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
			."category_code=:category_code";
 
        // prepare query for execution
        $stmt = $con->prepare($query);
 
        // posted values
        $perry_part_num=htmlspecialchars(strip_tags($_POST['perry_part_num']));
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
         
        // specify when this record was inserted to the database
        /*
		$created=date('Y-m-d H:i:s');
        $stmt->bindParam(':created', $created);
         */
		 
        // Execute the query
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Record was saved.</div>";
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
        }
         
    }
     
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 
<!-- html form here where the product information will be entered -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
		<tr>
			<td>Perry part no.</td>
			<td><input type="text" class="form-control" name="perry_part_num" /></td>
        </tr>
					
		<tr>
            <td>Short desc.</td>
            <td><input type="text" class="form-control" name="short_description"/></td>
        </tr>
		<tr>
            <td>Long desc.</td>
            <td><textarea type="text" class="form-control" name="long_description"></textarea></td>
        </tr>
		<tr>
            <td>Loc. in lab</td>
            <td><input type="text" class="form-control" name="location_in_lab"/></td>
        </tr>
		<tr>
            <td>Quantity</td>
            <td><input type="number" class="form-control" name="quantity"/></td>
        </tr>
		<tr>
            <td>Purch./rent</td>
            <td><input type="text" class="form-control" name="purchase_or_rent"></td>
        </tr>
		<tr>
            <td>Retail $</td>
            <td><input type="number" class="form-control" name="retail_price"/></td>
        </tr>
		<tr>
            <td>Retail promo $</td>
            <td><input type="number" class="form-control" name="retail_price_promo"/></td>
        </tr>
		<tr>
            <td>Retail markup</td>
            <td><input type="number" class="form-control" name="retail_markup"/></td>
        </tr>
		<tr>
            <td>Jobber $</td>
            <td><input type="number" class="form-control" name="jobber_price"/></td>
        </tr>
		<tr>
            <td>Jobber markup</td>
            <td><input type="number" class="form-control" name="jobber_markup"/></td>
        </tr>
		<tr>
            <td>Bulk $</td>
            <td><input type="number" class="form-control" name="bulk_price"/></td>
        </tr>
		<tr>
            <td>Bulk markup</td>
            <td><input type="number" class="form-control" name="bulk_markup"/></td>
        </tr>
		<tr>
            <td>Cost to replace</td>
            <td><input type="number" class="form-control" name="cost_to_replace"/></td>
        </tr>
		<tr>
            <td>Avg. cost</td>
            <td><input type="number" class="form-control" name="cost_avg"/></td>
        </tr>
		<tr>
            <td>Cat. code</td>
            <td><input type="number" class="form-control" name="category_code"/></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save' class='btn btn-primary' />
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
