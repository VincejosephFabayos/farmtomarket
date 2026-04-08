<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=db_cc205test", "root","");
    
    $stmt = $conn->prepare("SELECT prod.product_id, prod.farmer_id, prod.product_name, prod.category, prod.description, prod.unit_price, prod.status,COALESCE(inv.quantity_available, 0) as quantity_available FROM tb_product prod LEFT JOIN tb_inventory inv ON prod.product_id = inv.product_id ORDER BY prod.category, prod.product_name");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
} catch(Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
