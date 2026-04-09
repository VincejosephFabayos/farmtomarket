<?php
try {
    $conn = new PDO("mysql:host=sql305.infinityfree.com;dbname=if0_41611143_dbfarmtomarket", "if0_41611143","lo3HSuyJIl");
    
    $stmt = $conn->prepare("SELECT * FROM tb_farmer");
    $stmt->execute();
    $farmers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($farmers);
} catch(Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
