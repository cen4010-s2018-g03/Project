<?php
session_start();
$connect = mysqli_connect("localhost", "CEN4010_S2018g03", "cen4010_s2018", "CEN4010_S2018g03");
if(isset($_POST["add_to_cart"]))
{
     if(isset($_SESSION["shopping_cart"]))
     {
          $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
          if(!in_array($_GET["id"], $item_array_id))
          {
               $count = count($_SESSION["shopping_cart"]);
               $item_array = array(
                    'item_id'               =>     $_GET["id"],
                    'item_name'               =>     $_POST["hidden_name"],
                    'item_price'          =>     $_POST["hidden_price"],
                    'item_quantity'          =>     $_POST["quantity"]
               );
               $_SESSION["shopping_cart"][$count] = $item_array;
          }
          else
          {
               echo '<script>alert("Item Already Added")</script>';
               echo '<script>window.location="cart.php"</script>';
          }
     }
     else
     {
          $item_array = array(
               'item_id'               =>     $_GET["id"],
               'item_name'               =>     $_POST["hidden_name"],
               'item_price'          =>     $_POST["hidden_price"],
               'item_quantity'          =>     $_POST["quantity"]
          );
          $_SESSION["shopping_cart"][0] = $item_array;
     }
}
if(isset($_GET["action"]))
{
     if($_GET["action"] == "delete")
     {
          foreach($_SESSION["shopping_cart"] as $keys => $values)
          {
               if($values["item_id"] == $_GET["id"])
               {
                    unset($_SESSION["shopping_cart"][$keys]);
                    echo '<script>alert("Item Removed")</script>';
                    echo '<script>window.location="cart.php"</script>';
               }
          }
     }
}
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <link rel="shortcut icon" type="image/png" href="assets/img/logo-owl-color.png"/>

 <title>FAUOWLS</title>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="description" content="OneTech shop project">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
 <link href="plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
 <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
 <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
 <link rel="stylesheet" type="text/css" href="plugins/slick-1.8.0/slick.css">
 <link rel="stylesheet" type="text/css" href="styles/main_style.css">
 <link rel="stylesheet" type="text/css" href="styles/responsive.css">

 </head>

 <body>

 <div class="super_container">

 	<!-- Header -->

 	<header class="header">

 		<!-- Top Bar -->

 		<div class="top_bar">
 			<div class="container">
 				<div class="row">
 					<div class="col d-flex flex-row">

 						<div class="top_bar_contact_item"><div class="top_bar_icon"><img src="images/phone.png" alt=""></div><a style="color: #428bca">(561)297-3400</a></div>
 						<div class="top_bar_contact_item"><div class="top_bar_icon"><img src="images/mail.png" alt=""></div><a href="mailto:info@eng.fau.edu">info@eng.fau.edu</a></div>
 						<div class="top_bar_content ml-auto">
 							<div class="top_bar_user">
 								<div class="user_icon"><img src="images/user.svg" alt=""></div>
 								<div><a href="#" style="color: #428bca">Register</a></div>
 								<div><a href="#" style="color: #428bca">Sign in</a></div>
 							</div>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 		<!-- Header Main -->

 		<div class="header_main">
 			<div class="container">
 				<div class="row">

 					<!-- Logo -->
 					<div class="col-lg-2 col-sm-3 col-3 order-1">
 						<div class="logo_container">
 							<div class="logo"><img src="assets/img/webstore-logo.png" href="#" height="50" width="150" alt="">
 						</div>
 					</div>
                     </div>

                     <!-- Search -->
 					<div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
 						<div class="header_search">
 							<div class="header_search_content">
 								<div class="header_search_form_container">
 									<form action="#" class="header_search_form clearfix">
 										<input type="search" required="required" class="header_search_input" placeholder="Search for products...">
 										<div class="custom_dropdown">
 											<div class="custom_dropdown_list">
 												<span class="custom_dropdown_placeholder clc">All Categories</span>
 												<i class="fas fa-chevron-down"></i>
 												<ul class="custom_list clc">
 													<li><a class="clc" href="#">All Categories</a></li>
 													<li><a class="clc" href="#">Computers</a></li>
 													<li><a class="clc" href="#">Laptops</a></li>
 													<li><a class="clc" href="#">Cameras</a></li>
 													<li><a class="clc" href="#">Hardware</a></li>
 													<li><a class="clc" href="#">Smartphones</a></li>
 												</ul>
 											</div>
 										</div>
 										<button type="submit" class="header_search_button trans_300" value="Submit"><img src="images/search.png" alt=""></button>
 									</form>
 								</div>
 							</div>
 						</div>
 					</div>

 					<!-- Wishlist -->
 					<div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
 						<div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
 							<div class="wishlist d-flex flex-row align-items-center justify-content-end">
 								<div class="wishlist_icon"><img src="images/heart.png" alt=""></div>
 								<div class="wishlist_content">
 									<div class="wishlist_text"><a href="#">Wishlist</a></div>
 									<div class="wishlist_count">115</div>
 								</div>
 							</div>

 							<!-- Cart -->
 							<div class="cart">
 								<div class="cart_container d-flex flex-row align-items-center justify-content-end">
 									<div class="cart_icon">
 										<img src="images/cart.png" alt="">
 										<div class="cart_count"><span>10</span></div>
 									</div>
 									<div class="cart_content">
 										<div class="cart_text"><a href="cart.php">Cart</a></div>
 										<div class="cart_price">$85</div>
 									</div>
 								</div>
 							</div>
 						</div>
 					</div>
 				</div>
 			</div>


 		<!-- Main Navigation -->

 		<nav class="main_nav">
 			<div class="container">
 				<div class="row">
 					<div class="col">

 						<div class="main_nav_content d-flex flex-row">
               <!-- Categories Menu -->

               <div class="cat_menu_container">
                 <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
                   <div class="cat_burger"><span></span><span></span><span></span></div>
                   <div class="cat_menu_text">categories</div>
                 </div>

                 <ul class="cat_menu">
                   <li><a href="capacitor_listings.php">Capacitors<i class="fas fa-chevron-right ml-auto"></i></a></li>
                   <li><a href="diode_listings.php">Diodes<i class="fas fa-chevron-right"></i></a></li>
                   <li>
                     <a href="dip_switch_listings.php">Dip Switches<i class="fas fa-chevron-right"></i></a>
                   </li>
                   <li><a href="resistor_listings.php">Resistors<i class="fas fa-chevron-right"></i></a></li>
                   <li><a href="transistor_listings.php">Transistors<i class="fas fa-chevron-right"></i></a></li>
                   <li><a href="product_listings.php">View All<i class="fas fa-chevron-right"></i></a></li>
                 </ul>
               </div>


 							<!-- Main Nav Menu -->

               <div class="main_nav_menu ml-auto">
 								<ul class="standard_dropdown main_nav_dropdown">
 									<li><a href="index.php">Home<i class="fas fa-chevron-down"></i></a></li>
                                     <li><a href="product_listings.php">Products<i class="fas fa-chevron-down"></i></a></li>
 									<li class="hassubs">
 										<a href="#">Kits<i class="fas fa-chevron-down"></i></a>
 										<ul>
 											<li>
 												<a href="K3201.php">Intro to Logic Design<i class="fas fa-chevron-down"></i></a>
 											</li>
 											<li><a href="K3331C.php">Intro to Microprocessor Systems<i class="fas fa-chevron-down"></i></a></li>
 										</ul>
 									</li>
 									<li><a href="#footer">Contact<i class="fas fa-chevron-down"></i></a></li>
 								</ul>
 							</div>

 							<!-- Menu Trigger -->

 							<div class="menu_trigger_container ml-auto">
 								<div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
 									<div class="menu_burger">
 										<div class="menu_trigger_text">menu</div>
 										<div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
 									</div>
 								</div>
 							</div>

 						</div>
 					</div>
 				</div>
 			</div>
 		</nav>

 		<!-- Menu -->

 		<div class="page_menu">
 			<div class="container">
 				<div class="row">
 					<div class="col">

 						<div class="page_menu_content">

 							<div class="page_menu_search">
 								<form action="#">
 									<input type="search" required="required" class="page_menu_search_input" placeholder="Search for products...">
 								</form>
 							</div>
 							<ul class="page_menu_nav">
 								<li class="page_menu_item">
 									<a href="index.php">Home<i class="fa fa-angle-down"></i></a>
 								</li>
 								<li class="page_menu_item has-children">
 									<a href="#">Kits<i class="fa fa-angle-down"></i></a>
 									<ul class="page_menu_selection">

 										<li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
 										<li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
 										<li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
 										<li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
 									</ul>
 								</li>
 								<li class="page_menu_item has-children">
 									<a href="#">Services<i class="fa fa-angle-down"></i></a>
 									<ul class="page_menu_selection">
 										<li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
 										<li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
 										<li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
 										<li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
 									</ul>
 								</li>
 								<li class="page_menu_item"><a href="#">FAQ<i class="fa fa-angle-down"></i></a></li>
 								<li class="page_menu_item"><a href="#">Contact<i class="fa fa-angle-down"></i></a></li>
 							</ul>

 							<div class="menu_contact">
 								<div class="menu_contact_item"><div class="menu_contact_icon"><img src="images/phone_white.png" alt=""></div>(561)297-3400 </div>
 								<div class="menu_contact_item"><div class="menu_contact_icon"><img src="images/mail_white.png" alt=""></div><a href="mailto:info@eng.fau.edu">info@eng.fau.edu</a></div>
 							</div>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>

 	</header>

 	<!-- Cart -->




  <div style="clear:both"></div>
    <br />
    <h3>Order Details</h3>
    <div class="table-responsive">
         <table class="table table-bordered">
              <tr>
                   <th width="15%">Item Name</th>
                   <th width="15%">Quantity</th>
                   <th width="15%">Price</th>
                   <th width="15%">Total</th>
                   <th width="15%">Action</th>
              </tr>
              <?php
              if(!empty($_SESSION["shopping_cart"]))
              {
                   $total = 0;
                   foreach($_SESSION["shopping_cart"] as $keys => $values)
                   {
              ?>
              <tr>
                   <td><?php echo $values["item_name"]; ?></td>
                   <td><?php echo $values["item_quantity"]; ?></td>
                   <td>$ <?php echo $values["item_price"]; ?></td>
                   <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                   <td><a href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
              </tr>
              <?php
                        $total = $total + ($values["item_quantity"] * $values["item_price"]);
                   }
              ?>
              <tr>
                   <td colspan="3" align="right">Total</td>
                   <td align="right">$ <?php echo number_format($total, 2); ?></td>
                   <td></td>
              </tr>
              <?php
              }
              ?>

			  <!--<input type="submit" name="btnsubmit" value="Send Order" align: bottom right; href = "./inventory/Orders.php">-->
  </table>
  <li><a href="storeprocedure1.php">Purchase</a></li>
 
    </div>






	<!-- Footer -->

	<footer class="footer">
		<div class="container">
			<div class="row">

				<div class="col-lg-3 footer_col">
					<div class="footer_column footer_contact">
						<div class="logo_container">
							<div class="logo"><a href="#">Engineering Lab</a></div>
						</div>
						<div class="footer_title">Have a Question? Call Us</div>
						<div class="footer_phone">(561)297-3400</div>
						<div class="footer_contact_text">
							<p>777 Glades Road, Boca Raton, FL 33431</p>
							<p>Engineering East EE96 / Room 205</p>
						</div>
						<div class="footer_social">
							<ul>
								<li><a href="https://www.facebook.com/FAUCOECS/"><i class="fab fa-facebook-f"></i></a></li>
								<li><a href="https://twitter.com/FAUCOECS"><i class="fab fa-twitter"></i></a></li>
								<li><a href="https://www.youtube.com/user/fauengineer/featured"><i class="fab fa-youtube"></i></a></li>
								<li><a href="http://eng.fau.edu/"><i class="fab fa-google"></i></a></li>
								<li><a href="https://vimeo.com/fauengcompsci"><i class="fab fa-vimeo-v"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

                <!--spacer-->
                <div class="col-lg-2"></div>

				<div class="col-lg-3 footer_col">
					<div class="footer_column">
						<div class="footer_title">Contacts</div>
						<ul class="footer_list">
							<li><a href="#"><p style="color: #fafafa">C. Perry Weinthal: Lab Manager, Building Manager Florida Atlantic University</p></a></li>
							<li><a href="#" style="color: #fafafa">Contact 2</a></li>
							<li><a href="#" style="color: #fafafa">Contact 3</a></li>
						</ul>
					</div>
				</div>

                <!--spacer-->
                <div class="col-lg-2"></div>

				<div class="col-lg-2">
					<div class="footer_column">
						<div class="footer_title">Support</div>
						<ul class="footer_list">
							<li><a href="#" style="color: #fafafa">Contact Us</a></li>
							<li><a href="#" style="color: #fafafa">Help</a></li>
							<li><a href="#" style="color: #fafafa">Feedback</a></li>
							<li><a href="#" style="color: #fafafa">Browser Support</a></li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</footer>

	<!-- Order button/store procedure -->
<!--<?php

  $d1 = date("Y-m-d H:i:s");
 // mysqli_query($connect, "CALL pr_user_order(431939, '$d1', @res)") or die("Query fail: " . mysqli_error());
  ?>
  echo "order num is " . $res;

  email to znu
  $fgmembersite = UserEmail();
  echo "email i s is " . $fgmembersite;
  $result = mysqli_query($connect, "SELECT z_num FROM Store_users WHERE FAU_email = $fgmembersite") or die("Query fail: ") . mysqli_error();
  $znum = mysql_fetch_assoc($result);
  echo "z num is " . $znum;

   ?>-->

	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col">

					<div class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-start">
						<div class="copyright_content"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</div>
						<div class="logos ml-sm-auto">
							<ul class="logos_list">
								<li><a href="#"><img src="images/logos_1.png" alt=""></a></li>
								<li><a href="#"><img src="images/logos_2.png" alt=""></a></li>
								<li><a href="#"><img src="images/logos_3.png" alt=""></a></li>
								<li><a href="#"><img src="images/logos_4.png" alt=""></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/greensock/TweenMax.min.js"></script>
<script src="plugins/greensock/TimelineMax.min.js"></script>
<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="plugins/greensock/animation.gsap.min.js"></script>
<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/slick-1.8.0/slick.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
