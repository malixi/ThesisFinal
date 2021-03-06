<?php

session_start();
require_once 'connector.php';
require_once 'configuration.php';
?>
<html>

<head>
    <title>Llanes Farm</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Custom Theme files -->
    <!--theme-style-->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!--//theme-style-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"/>
    <script src="js/toastrInit.js"> </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Custom Theme files -->
    <!--theme-style-->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!--//theme-style-->

    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!--fonts-->
    <link href='//fonts.googleapis.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
    <!--//fonts-->
    <!-- start menu -->
    <link href="css/memenu.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="js/memenu.js"></script>
    <script>
        $(document).ready(function() {
            $(".memenu").memenu();
        });
    </script>
    <script src="js/simpleCart.min.js">
    </script>
</head>

<body>
    <!--header-->
    <?php 
      include 'header.php';

      if (isset($_GET['action']) && $_GET['action'] == 'success') {
        echo "<script>toastr.info('Success', 'Removed All Products In Cart');</script>";
      }

      if (isset($_GET['action']) && $_GET['action'] == 'error') {
        echo "<script>toastr.error('Error', 'No Products In Cart');</script>";
      }

      if (isset($_GET['action']) && $_GET['action'] == 'successupdate') {
        echo "<script>toastr.info('Success', 'Cart Updated');</script>";
      }

      if (isset($_GET['action']) && $_GET['action'] == 'errorupdate') {
        echo "<script>toastr.error('Error', 'Invalid Product Quantity');</script>";
      }

      if (isset($_GET['action']) && $_GET['action'] == 'successremove') {
        echo "<script>toastr.info('Success', 'Product Removed');</script>";
      }

      if (isset($_GET['action']) && $_GET['action'] == 'successadd') {
        echo "<script>toastr.info('Success', 'Product Added To Cart');</script>";
      }


    ?>

    <!-- search-scripts -->
    <script src="js/classie.js"></script>
    <script src="js/uisearch.js"></script>
    <script>
        new UISearch(document.getElementById('sb-search'));
    </script>
    <!-- //search-scripts -->

    <div class="ca-r">
        <div class="cart box_1">
            <a href="view_cart.php">
              <h3> 
                <div class="total">
                  <span class="">My Cart</span> 
                </div>
                <img src="images/cart.png" alt=""/>
                  <?php
                    if(isset($_SESSION["cart_products"])){
                        echo count($_SESSION["cart_products"]);
                    }
                  ?>
              </h3>
            </a>
        </div>
    </div>
    <div class="clearfix"> </div>
    </div>

    </div>
    </div>
    <div class="container">
        <?php include 'navbar.php'; ?>
    </div>
    <!-- grow -->
    <div class="grow">
        <div class="container">
            <h2>My Cart</h2>
        </div>
    </div>
    <!-- grow -->
    <div class="container">
        <div class="check">
            <div class="col-md-9 cart-items">
                <!-- LOOP THIS -->
                <?php 
                  if(empty($_SESSION['cart_products'])){
                    echo "<h2>No products in the cart</h2><br><br>";
                  } else {
                  if(isset($_SESSION["cart_products"])){ //check session var
                    $total = 0; //set initial total value
                    $b = 0; //var for zebra stripe table
                    foreach ($_SESSION["cart_products"] as $cart_itm){
                      //set variables to use in content below
                      $product_image = $cart_itm["product_image"];
                      $product_name = $cart_itm["product_name"];
                      $product_qty = $cart_itm["product_qty"];
                      $product_price = $cart_itm["product_price"];
                      $product_code = $cart_itm["product_code"];
                      $subtotal = ($product_price * $product_qty);
                ?>
                <form method="post" action="cart_update.php">
                  <div class="cart-header">
                      <div>
                        <label class="close1"" for="delete"></label>
                        <input Onclick=\"return ConfirmDelete()\" type="submit" style="display:none; visibility:hidden;" class="btn btn-primary" id="delete" name="remove_code[]" value=<?php echo $product_code ?> />
                      </div>
                      <div class="cart-sec simpleCart_shelfItem">
                          <div class="cart-item cyc">
                              <img src=<?php if($product_image == "Submit"){ echo "admin/productimage/logo.png"; } else { echo "admin/productimage/".$product_image.""; } ?> class="img-responsive" alt="" />
                          </div>
                          <div class="cart-item-info">
                              <h3><a href="#"><?php echo $product_name; ?></a><span><?php echo $product_code; ?></span></h3>
                              <ul class="qty">
                                  <li>
                                      <p>Quantity: <input type="number" min="1" style="width:40px;" maxlength="2" name=<?php echo "product_qty[".$product_code."]" ?> value=<?php echo $product_qty ?> /></p>
                                  </li>
                                  <li>
                                      <p>Price: <?php echo $product_price ?></p>
                                  </li>
                                  <li>
                                      <p>Total Price: <?php echo $product_price * $product_qty ?></p>
                                  </li>
                              </ul>
                              <div class="delivery">
                                  <div class="clearfix"></div>
                              </div>
                          </div>
                          <div class="clearfix"></div>
                      </div>
                  </div>
                <?php
                      $total = ($total + $subtotal);
                    }
                    $grand_total = $total + $shipping_cost; //grand total including shipping cost
                      foreach($taxes as $key => $value){ //list and calculate all taxes in array
                          $tax_amount     = round($total * ($value / 100));
                          $tax_item[$key] = $tax_amount;
                          $grand_total    = $grand_total + $tax_amount;  //add tax val to grand total
                      }
                    $list_tax = '';
                      foreach($tax_item as $key => $value){ //List all taxes
                        $list_tax .= $key. ' : '. $currency. sprintf("%01.2f", $value).'<br />';
                      }
                    $shipping_cost = ($shipping_cost)?'Shipping Cost : '.$currency. sprintf("%01.2f", $shipping_cost).'<br />':'';
                  }
                }
                ?>
                <!-- LOOP END -->
            </div>
            <div class="col-md-3 cart-total">
                <a class="continue" href="products.php">Continue Shopping</a>
                <div class="price-details">
                    <h3>Price Details</h3>
                    <span>Total</span>
                    <span class="total1"><?php 
                      if(empty($grand_total)){
                        echo "---";
                      } else {
                        echo $grand_total;
                      }
                        ?></span>
                    <span>Discount</span>
                    <span class="total1">---</span>
                    <span>Delivery Charges</span>
                    <span class="total1">---</span>
                    <div class="clearfix"></div>
                </div>
                <ul class="total_price">
                    <li class="last_price">
                        <h4>TOTAL</h4></li>
                    <li class="last_price"><span><?php 
                      if(empty($grand_total)){
                        echo "---";
                      } else {
                        echo sprintf("%01.2f", $grand_total);
                      }
                        ?></span></li>
                    <div class="clearfix"> </div>
                </ul>

                <div class="clearfix"></div>

                <button class="order-btn" type="submit">Update Cart</button>
                <a href="unset.php" class="order">Remove All</a>
                </form>

                <div class="order" for="submit">
                  <?php
                    echo '
                      <form method="POST" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
                        <input type="hidden" name="business" value="carlolo@gmail.com">
                        <input type="hidden" name="cmd" value="_cart">
                        <input type="hidden" name="upload" value="1">';
                          $x = 0;
                        if(isset($_SESSION["cart_products"])){
                        foreach ($_SESSION["cart_products"] as $cart_itm){
                          //set variables to use in content below
                          $product_name = $cart_itm["product_name"];
                          $product_qty = $cart_itm["product_qty"];
                          $product_price = $cart_itm["product_price"];
                          $product_code = $cart_itm["product_code"];
                            $x++;
                          echo '<input type="hidden" name="item_name_'.$x.'" value="'.$product_name.'">';
                          echo '<input type="hidden" name="item_number_'.$x.'" value="'.$product_code.'">';
                          echo '<input type="hidden" name="amount_'.$x.'" value="'.$product_price.'">';
                          echo '<input type="hidden" name="quantity_'.$x.'" value="'.$product_qty.'">';
                          }
                        }
                    echo'
                        <input type="hidden" name="shipping" value="'.$shipping_cost.'">
                        <input type="hidden" name="tax" value="0.12">
                        <input type="hidden" name="currency_code" value="PHP">

                        <input type="hidden" name="cancel_return" value="http://localhost/THESISfinal/cancel.php">
                        <input type="hidden" name="return" value="http://localhost/THESISfinal/successproccess.php">';
                        if(isset($_SESSION['cart_products'])){
                          echo'
                        <button class="order-btn" type="submit">Check Out With Paypal</button>
                      </form>';
                        } else {
                          echo'
                        <button class="order-btn" type="submit" disabled>Check Out With Paypal</button>
                      </form>';
                        }
                    ?>
                </div>
                <div class="total-item">
                </div>
            </div>

            <div class="clearfix"> </div>
        </div>
    </div>


    <!--//content-->
    <?php include 'footer.php'; ?>
    </div>
    </div>
</body>
</html>