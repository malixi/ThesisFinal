<?php
session_start();
include_once("configuration.php");

//add product to session or create new one
if(isset($_POST["type"]) && $_POST["type"]=='add' && $_POST["product_qty"]>0){
	$add = "<script>location.href='view_cart.php?action=successadd';</script>";
	foreach($_POST as $key => $value){ //add all post vars to new_product array
		$new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING);
    }
	//remove unecessary vars
	unset($new_product['type']);
	unset($new_product['return_url']);

 	//we need to get product name and price from database.
    $statement = $mysqli->prepare("SELECT name, price, image FROM products WHERE product_code=? LIMIT 1");
    $statement->bind_param('s', $new_product['product_code']);
    $statement->execute();
    $statement->bind_result($product_name, $price, $image);

	while($statement->fetch()){

		//fetch product name, price from db and add to new_product array
        $new_product["product_name"] = $product_name;
        $new_product["product_price"] = $price;
        $new_product["product_image"] = $image;

        if(isset($_SESSION["cart_products"])){  //if session var already exist
            if(isset($_SESSION["cart_products"][$new_product['product_code']])) //check item exist in products array
            {
                unset($_SESSION["cart_products"][$new_product['product_code']]); //unset old array item
            }
        }
        $_SESSION["cart_products"][$new_product['product_code']] = $new_product; //update or create product session with new item
    }
}


//update or remove items
if(isset($_POST["product_qty"]) || isset($_POST["remove_code"]))
{
	//update item quantity in product session
	if(isset($_POST["product_qty"]) && is_array($_POST["product_qty"])){	
		$update = "<script>location.href='view_cart.php?action=successupdate';</script>";
		foreach($_POST["product_qty"] as $key => $value){
			if(is_numeric($value)){
				if($value <= 0){
					echo "<script>location.href='view_cart.php?action=errorupdate';</script>";
				} else {
					$_SESSION["cart_products"][$key]["product_qty"] = $value;
				}
			}
		}
	}
	//remove an item from product session
	if(isset($_POST["remove_code"]) && is_array($_POST["remove_code"])){
		$remove = "<script>location.href='view_cart.php?action=successremove';</script>";
		foreach($_POST["remove_code"] as $key){
			unset($_SESSION["cart_products"][$key]);
		}
	}
}

//back to return url
if(isset($remove)){
	echo $remove;
}else if(isset($update)){
	echo $update;
}else if(isset($add)){
	echo $add;
}else{
	$return_url = (isset($_POST["return_url"]))?urldecode($_POST["return_url"]):''; //return url
	header('Location: view_cart.php');
}
?>
