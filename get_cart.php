<?php
$cartFile = 'cart_data.json';

if(file_exists($cartFile)) {
    echo file_get_contents($cartFile);
} else {
    echo json_encode([]);
}
?>
