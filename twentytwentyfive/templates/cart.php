<?php

function display_cart(){
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart']) ) {
        echo "<h2>Your Cart</h2>";
        echo "<ul>";
        foreach($_SESSION['cart'] as $product_id){
            $product = get_product($product_id);
            echo "<li>" . $product['name'] . "- $" . $product['price'] . "</li>";
        }
        echo "</ul>";
    }
    else {
        echo "Your cart is empty";
        }
}

display_cart();

?>