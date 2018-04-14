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
            <li><a href="images.php">Images</a></li>
            <li><a href="#">Back-End</a></li>
            <li><a href="#">Categories</a></li>
            <li><a href="">Should</a></li>
            <li><a href="">Go</a></li>
            <li><a href="">Here</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Kits Inventory Selection</h1>

          <div class="row placeholders">
              <div class="col-xs-6 col-sm-3 placeholder">
              <form class="navbar-form navbar-left" method="POST">
            <input type="text" class="form-control" placeholder="Enter Part #" name="search">
            <input type="SUBMIT" name="submit" value="Search" />
          </form>
		  </div>
          </div>
        

          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Perry Part #</th>
                  <th>Short Description</th>
                </tr>
              </thead>
              <tbody>
            
<?php
//connect to db
$mysqli = NEW MySQLi("localhost", "CEN4010_S2018g03", "cen4010_s2018", "CEN4010_S2018g03");

$resultSet = $mysqli->query("select distinct perry_part_num,short_description from Inventory i inner join Kits k on i.perry_part_num = k.item");


while($row = mysqli_fetch_array($resultSet)){
    echo "<tr>";
    echo "<td>" . $row['perry_part_num'] . "</td>";
    echo "<td>" . $row['short_description'] . "</td>";
	echo "<td><a href='kit_inventory.php?id=".$row['perry_part_num']."'>Select</a></td>";
    //echo "<td>" . "<button type='button'>Save</button>" . "</td>";
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