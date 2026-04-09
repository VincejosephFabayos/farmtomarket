<?php
try {
    $conn = new PDO("mysql:host=sql305.infinityfree.com;dbname=if0_41611143_dbfarmtomarket", "if0_41611143","lo3HSuyJIl");
    
    $stmt = $conn->prepare("SELECT inv.inventory_id, inv.product_id, inv.quantity_available, inv.date_updated, 
                                   prod.product_name, prod.category, prod.unit_price, prod.farmer_id,
                                   farm.first_name, farm.last_name 
                            FROM tb_inventory inv
                            JOIN tb_product prod ON inv.product_id = prod.product_id
                            JOIN tb_farmer farm ON prod.farmer_id = farm.farmer_id
                            ORDER BY farm.first_name, prod.product_name");
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($inventory);
} catch(Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
