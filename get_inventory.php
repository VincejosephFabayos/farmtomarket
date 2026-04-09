<?php
try {
    $conn = new PDO("mysql:host=sql305.infinityfree.com;dbname=if0_41611143_dbfarmtomarket", "if0_41611143","lo3HSuyJIl");
    
    $stmt = $conn->prepare("SELECT * FROM tb_inventory");
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($inventory);
} catch(Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
