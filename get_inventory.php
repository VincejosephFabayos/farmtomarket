<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=db_cc205test", "root","");
    
    $stmt = $conn->prepare("SELECT * FROM tb_inventory");
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($inventory);
} catch(Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>