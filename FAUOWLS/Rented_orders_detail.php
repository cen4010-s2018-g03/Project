<?php
$id = $_GET['id'];
?>   
<?PHP
require_once("/home/CEN4010_S2018g03/public_html/FAUOWLS/security/include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("/~CEN4010_S2018g03/FAUOWLS/security/login.php");
    exit;
}
?>

<html lang="en">
  <head>
    <link rel="shortcut icon" type="image/png" href="../assets/img/logo-owl-color.png"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">

    <title>FAUOWLS</title>

    <!-- Bootstrap core CSS -->
    <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="inventory.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#" id="navbar-header"><img src="../assets/img/logo-owl-color.svg" width="45" height="25"/></a>
          <a class="navbar-brand" href="#" id="navbar-header" style="color: #428bca">FAUOWLS</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../security/logout.php" style="color:#428bca">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar"  style="background-color:#036">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="index.php">Inventory <span class="sr-only">(current)</span></a></li>
			<li><a href="Inventory_movement.php">Inventory Movement</a></li>
            <li><a href="images.php">Images</a></li>
            <li><a href="Orders.php">Pending Orders</a></li>
            <li><a href="Orders_past.php">Previous Orders</a></li>
            <li><a href="Orders_canceled.php">Canceled Orders</a></li>
			<li><a href="Return_rented.php">Return Rented Items</a></li>
            <li><a href="Kit_creation.php">Kits Creation</a></li>
            <li><a href="kit.php">Kits Inventory</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Return Rented Items</h1>

        

          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Perry Part #</th>
                  <th>Short Description</th>
				  <th>Quantity</th>
				  <th>Location</th>
                </tr>
              </thead>
              <tbody>
            
<?php
//connect to db
$mysqli = NEW MySQLi("localhost", "CEN4010_S2018g03", "cen4010_s2018", "CEN4010_S2018g03");
//$id = $_GET['id'];
//$resultSet = $mysqli->query("select item, input, quantity from Kits k where '$id' = k.item");
//$resultSet = $mysqli->query("select i.perry_part_num, short_description, t.quantity, location_in_lab from Inventory_Transaction t inner join Inventory i on t.perry_part_num=i.perry_part_num where '$id' = t.transaction_num;");
$resultSet = $mysqli->query("select i.perry_part_num, short_description, t.quantity, location_in_lab from Inventory_Transaction t inner join Inventory i on t.perry_part_num=i.perry_part_num inner join User_order_items u on t.perry_part_num=u.perry_part_num where '$id' = t.transaction_num AND '$id' =u.order_num AND 1=u.rented_bool AND 0=u.returned_bool;");

while($row = mysqli_fetch_array($resultSet)){
    echo "<tr>";
    echo "<td>" . $row['perry_part_num'] . "</td>";
    echo "<td>" . $row['short_description'] . "</td>";
	echo "<td>" . $row['quantity'] . "</td>";
	echo "<td>" . $row['location_in_lab'] . "</td>";
	echo "<td><a href='Rented_return_process.php?id2=".$row['perry_part_num']."&quantity=" . $row['quantity'] . "&id=$id'>Return</a></td>";
    echo "</tr>";
}
?>    
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>