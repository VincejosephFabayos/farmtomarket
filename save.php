<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=db_cc205test", "root","");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(["msg"=>"error", "error"=>$e->getMessage()]);
    exit;
}

if(isset($_POST["delete_farmer_id"])) {
    try {
        $stmt = $conn->prepare("DELETE FROM tb_farmer WHERE farmer_id = ?");
        $result = $stmt->execute([$_POST["delete_farmer_id"]]);
        echo json_encode(["msg"=>$result?"ok":"error"]);
    } catch(PDOException $e) {
        echo json_encode(["msg"=>"error", "error"=>$e->getMessage()]);
    }
    exit;
}

if(isset($_POST["user_name"]) && isset($_POST["password"])) {
    try {
        $stmt = $conn->prepare("INSERT INTO tb_customer(first_name, middle_name, last_name, user_name, password) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([
            $_POST["first_name"],
            $_POST["middle_name"],
            $_POST["last_name"],
            $_POST["user_name"],
            $_POST["password"]
        ]);
        echo json_encode(["msg"=>$result?"ok":"error"]);
    } catch(PDOException $e) {
        echo json_encode(["msg"=>"error", "error"=>$e->getMessage()]);
    }
    exit;
}

if(isset($_POST["farmer_id"]) && isset($_POST["contact_number"])) {
    try {
        $stmt = $conn->prepare("INSERT INTO tb_farmer(farmer_id, first_name, last_name, contact_number, email, address, registration_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([
            $_POST["farmer_id"],
            $_POST["first_name"],
            $_POST["last_name"],
            $_POST["contact_number"],
            $_POST["email"],
            $_POST["address"],
            $_POST["registration_date"],
            $_POST["status"]
        ]);
        echo json_encode(["msg"=>$result?"ok":"error"]);
    } catch(PDOException $e) {
        echo json_encode(["msg"=>"error", "error"=>$e->getMessage()]);
    }
    exit;
}


if(isset($_POST["product_id"]) && isset($_POST["farmer_id"]) && isset($_POST["product_name"])) {
    $stmt = $conn->prepare("INSERT INTO tb_product(product_id, farmer_id, product_name, category, description, unit_price, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([
        $_POST["product_id"],
        $_POST["farmer_id"],
        $_POST["product_name"],
        $_POST["category"],
        $_POST["description"],
        $_POST["unit_price"],
        $_POST["status"]
    ]);
    echo json_encode(["msg"=>$result?"ok":"error"]);
    exit;
}

if(isset($_POST["inventory_id"])) {
    $stmt = $conn->prepare("INSERT INTO tb_inventory(inventory_id, product_id, quantity_available, date_updated) VALUES (?, ?, ?, ?)");
    $result = $stmt->execute([
        $_POST["inventory_id"],
        $_POST["product_id"],
        $_POST["quantity_available"],
        $_POST["date_updated"]
    ]);
    echo json_encode(["msg"=>$result?"ok":"error"]);
    exit;
}

if(isset($_POST["customer_id"])) {
    $stmt = $conn->prepare("INSERT INTO tb_customer(customer_id, customer_name, contact_number, email, address, registration_date) VALUES (?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([
        $_POST["customer_id"],
        $_POST["customer_name"],
        $_POST["contact_number"],
        $_POST["email"],
        $_POST["address"],
        $_POST["registration_date"]
    ]);
    echo json_encode(["msg"=>$result?"ok":"error"]);
    exit;
}

if(isset($_POST["orderdetails_id"])) {
    $stmt = $conn->prepare("INSERT INTO tb_order_details(orderdetails_id, order_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?, ?)");
    $result = $stmt->execute([
        $_POST["orderdetails_id"],
        $_POST["order_id"],
        $_POST["product_id"],
        $_POST["quantity"],
        $_POST["subtotal"]
    ]);
    echo json_encode(["msg"=>$result?"ok":"error"]);
    exit;
}

if(isset($_POST["order_id"])) {
    $stmt = $conn->prepare("INSERT INTO tb_order(order_id, customer_id, order_date, total_amount, order_status, payment_status) VALUES (?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([
        $_POST["order_id"],
        $_POST["customer_id"],
        $_POST["order_date"],
        $_POST["total_amount"],
        $_POST["order_status"],
        $_POST["payment_status"]
    ]);
    echo json_encode(["msg"=>$result?"ok":"error"]);
    exit;
}

echo json_encode(["msg"=>"no valid data"]);
?>
