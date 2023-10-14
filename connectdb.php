<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_name = trim($_POST['menu_name']);
    $menu_desc = trim($_POST['menu_desc']);
    $price = trim($_POST['price']);
    
    if(strlen($menu_name) <= 100 && strlen($menu_desc) <= 1000 && $price > 0) {
        $conn = new mysqli('localhost','patigayonjason','123456789','pointofsale');
        if($conn->connect_error){
            echo json_encode(['status' => 'error', 'message' => $conn->connect_error]);
            die("Connection Failed : ". $conn->connect_error);
        } else {
            $stmt = $conn->prepare("INSERT INTO ref_menu(menu_name, menu_desc, price) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $menu_name, $menu_desc, $price);
            $execval = $stmt->execute();
            
            if($execval){
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $stmt->error]);
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>
