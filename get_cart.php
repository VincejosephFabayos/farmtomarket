<?php
$conn = new PDO("mysql:host=sql305.infinityfree.com;dbname=if0_41611143_dbfarmtomarket", "if0_41611143","lo3HSuyJIl");

if(file_exists($cartFile)) {
    echo file_get_contents($cartFile);
} else {
    echo json_encode([]);
}
?>
