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
            <li><a href="#" style="color:#428bca">Dashboard</a></li>
            <li><a href="#" style="color:#428bca">Settings</a></li>
            <li><a href="#" style="color:#428bca">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar"  style="background-color:#036">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Inventory <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Other</a></li>
            <li><a href="#">Back-End</a></li>
            <li><a href="#">Categories</a></li>
            <li><a href="">Should</a></li>
            <li><a href="">Go</a></li>
            <li><a href="">Here</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Inventory</h1>

          <div class="row placeholders">
              <div class="col-xs-6 col-sm-3 placeholder">
              <form class="navbar-form navbar-left" method="POST">
            <input type="text" class="form-control" placeholder="Enter Part #" name="search">
            <input type="SUBMIT" name="submit" value="Search" />
          </form>
            </div>
          <button type="button">Add Items</button>
          </div>
        

          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Perry Part #</th>
                  <th>Short Description</th>
                  <th>Long Description</th>
                  <th>Location In Lab</th>
                  <th>Quantity</th>
                  <th>Purchase Or Rent</th>
                  <th>Retail Price</th>
                  <th>Retail Price Promo</th>
                  <th>Retail Markup</th>
                  <th>Jobber Price</th>
                  <th>Jobber Markup</th>
                  <th>Bulk Price</th>
                  <th>Bulk Markup</th>
                  <th>Cost To Replace</th>
                  <th>Cost Average</th>
                  <th>Edit/Delete</th>
                </tr>
              </thead>
              <tbody>
            
<?php
//connect to db
$mysqli = NEW MySQLi("localhost", "CEN4010_S2018g03", "cen4010_s2018", "CEN4010_S2018g03");

$resultSet = $mysqli->query("SELECT * FROM Inventory");


while($row = mysqli_fetch_array($resultSet)){
    echo "<tr>";
    echo "<td>" . $row['perry_part_num'] . "</td>";
    echo "<td>" . $row['short_description'] . "</td>";
    echo "<td>" . $row['long_description'] . "</td>";
    echo "<td>" . $row['location_in_lab'] . "</td>";
    echo "<td>" . $row['quantity'] . "</td>";
    echo "<td>" . $row['purchase_or_rent'] . "</td>";
    echo "<td>" . $row['retail_price'] . "</td>";
    echo "<td>" . $row['retail_price_promo'] . "</td>";
    echo "<td>" . $row['retail_markup'] . "</td>";
    echo "<td>" . $row['jobber_price'] . "</td>";
    echo "<td>" . $row['jobber_markup'] . "</td>";
    echo "<td>" . $row['bulk_price'] . "</td>";
    echo "<td>" . $row['bulk_markup'] . "</td>";
    echo "<td>" . $row['cost_to_replace'] . "</td>";
    echo "<td>" . $row['cost_avg'] . "</td>";
    echo "<td>" . "<button type='button'>Edit</button>" . "<button type='button'>Delete</button>" . "</td>";
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