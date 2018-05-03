<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
     
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
         
    <!-- custom css -->
    <style>
    .m-r-1em{ margin-right:1em; }
    .m-b-1em{ margin-bottom:1em; }
    .m-l-1em{ margin-left:1em; }
    .mt0{ margin-top:0; }
    </style>
 
</head>
<body>
 
    <!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Inventory</h1>
        </div>
     
        <!-- PHP code to read records will be here -->
        <?php
			// include database connection
			include 'config/database.php';
 
			// delete message prompt will be here
			$action = isset($_GET['action']) ? $_GET['action'] : "";
 
			// if it was redirected from delete.php
			if($action=='deleted'){
				echo "<div class='alert alert-success'>Record was deleted.</div>";
			}
 
			// select all data		
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
				."FROM Inventory ORDER BY perry_part_num ASC";
			$stmt = $con->prepare($query);
			$stmt->execute();
			
			// this is how to get number of rows returned
			$num = $stmt->rowCount();
			
			// link to create record form
			echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Item</a>";
			
			//check if more than 0 record found
			if($num>0){
			
				// data from database will be here
				echo "<table class='table table-hover table-responsive table-bordered'>";//start table
			
				//creating our table heading
				echo "<tr>";
				//echo "<th>ID</th>";
				echo "<th>Part no.</th>";
				echo "<th>Short description</th>";
				echo "<th>Long description</th>";
				echo "<th>Location in lab</th>";
				echo "<th>Quantity</th>";
				echo "<th>Purchase or rent</th>";
				echo "<th>Retail $</th>";
				echo "<th>Retail promo $</th>";
				echo "<th>Retail markup</th>";
				echo "<th>Jobber $</th>";
				echo "<th>Jobber markup</th>";
				echo "<th>Bulk $</th>";
				echo "<th>Bulk markup</th>";
				echo "<th>Cost to replace</th>";
				echo "<th>Avg. cost</th>";
				echo "<th>Category code</th>";
				echo "<th>Action</th>";
				echo "</tr>";
     
				// table body will be here
				// retrieve our table contents
				// fetch() is faster than fetchAll()
				// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					// extract row
					// this will make $row['firstname'] to
					// just $firstname only
					extract($row);
					
					// creating new table row per record
					echo "<tr>";
						//echo "<td>{$id}</td>";
						echo "<td>{$perry_part_num}</td>";
						echo "<td>{$short_description}</td>";
						echo "<td>{$long_description}</td>";
						echo "<td>{$location_in_lab}</td>";
						echo "<td>{$quantity}</td>";
						echo "<td>{$purchase_or_rent}</td>";
						echo "<td>&#36;{$retail_price}</td>";
						echo "<td>&#36;{$retail_price_promo}</td>";
						echo "<td>{$retail_markup}</td>";
						echo "<td>&#36;{$jobber_price}</td>";
						echo "<td>{$jobber_markup}</td>";
						echo "<td>&#36;{$bulk_price}</td>";
						echo "<td>{$bulk_markup}</td>";
						echo "<td>&#36;{$cost_to_replace}</td>";
						echo "<td>&#36;{$cost_avg}</td>";
						echo "<td>{$category_code}</td>";
						echo "<td>";
							// read one record 
							echo "<a href='read_one.php?perry_part_num={$perry_part_num}' class='btn btn-info m-r-1em'>Read</a>";
							
							// we will use this links on next part of this post
							echo "<a href='update.php?perry_part_num={$perry_part_num}' class='btn btn-primary m-r-1em'>Edit</a>";
				
							// we will use this links on next part of this post
							echo "<a href='#' onclick='delete_user({$perry_part_num});'  class='btn btn-danger'>Delete</a>";
						echo "</td>";
					echo "</tr>";
				}
 
				// end table
				echo "</table>";
     
			}
 
			// if no records found
			else{
				echo "<div class='alert alert-danger'>No records found.</div>";
			}
		?>
	</div> <!-- end .container -->
     
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
<!-- confirm delete record will be here -->
<script type='text/javascript'>
// confirm record deletion
function delete_user( perry_part_num ){
     
    var answer = confirm('Are you sure?');
    if (answer){
        // if user clicked ok, 
        // pass the id to delete.php and execute the delete query
        window.location = 'delete.php?perry_part_num=' + perry_part_num;
    } 
}
</script>
 
</body>
</html>