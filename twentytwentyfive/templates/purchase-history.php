<?php

function display_purchase_history() {
    $user_id = get_current_user();
    $orders = get_purchase_history($user_id);

    if( !empty($orders) ) {
        echo "<h2>Purchase History</h2>";
        echo "<ul>";

        foreach( $orders as $order ) {
            echo "<li>";
            echo "<strong>Order ID:</strong> $order->order_id";
            echo "<br><strong>Order Date:</strong> $order->order_date";
            echo "<br><strong>Order Total:</strong> $order->order_total";
            echo "</li>";
        }
        echo "</ul>";
    }
    else {
        echo "<p>No purchase history found.</p>";
    }
}

display_purchase_history();
?>