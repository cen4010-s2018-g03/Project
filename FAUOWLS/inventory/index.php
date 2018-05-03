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
                        <!--
                        <li><a href="#" style="color:#428bca">Dashboard</a></li>
                        <li><a href="#" style="color:#428bca">Settings</a></li>
                        -->
                        <li><a href="/~CEN4010_S2018g03/FAUOWLS/security/logout.php" style="color:#428bca">Logout</a></li>
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
                        <!--<li><a href="#">Barcodes</a></li>
                        <li><a href="#">Data sheets</a></li>
                        <li><a href="">Categories</a></li>
                        <li><a href="">Go</a></li>
                        <li><a href="">Here</a></li>-->
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Inventory</h1>
                    
                    <div class="row placeholders">
                        <!--
                        <div class="col-xs-6 col-sm-3 placeholder">
                            <form class="navbar-form navbar-left" method="POST">
                                <input type="text" class="form-control" placeholder="Enter Part #" name="search">
                                <input type="SUBMIT" name="submit" value="Search" />
                            </form>
                        </div>
                        -->
                        <div class="col-xs-6 col-sm-3 placeholder">
                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                Select CSV file to add new items to Inventory. Fields are in the order shown in the table below, with an additional five spaces at the end to add barcodes:
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                <input type="submit" value="Upload File" name="submit">
                            </form>
                        </div>
                        <div class="col-xs-6 col-sm-3 placeholder">
                            <form action="export.php" method="post" enctype="multipart/form-data">
                                Click to download export .xsl of current inventory:
                                <button class="btn"><i class="fa fa-download"></i> Download</button>
                            </form>
                        </div>
                        <!--
                        <button type="button">Add Items</button>
                        -->
                    </div>
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
                            echo "<br/>";
                            echo "<br/>";
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
                    </div> 
                    <!--
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
                                
                                </*?php 
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
                                    */
                                }
                                ?>    
                            </tbody>
                        </table>
                    </div>-->
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
