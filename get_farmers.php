<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=db_cc205test", "root","");
    
    $stmt = $conn->prepare("SELECT * FROM tb_farmer");
    $stmt->execute();
    $farmers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($farmers);
} catch(Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
