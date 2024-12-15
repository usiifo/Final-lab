<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
    include_once '../db/Database.php';
    $database = new Database();
    $db = $database->connect();
    
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->username) || !isset($data->password)) {
        http_response_code(400);
        echo json_encode(["message" => "Invalid input. Username and password are required."]);
        exit;
    }
    
    $query = "SELECT id, username FROM users WHERE username = :username AND pass = :password";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':username', $data->username);
    $stmt->bindParam(':password', $data->password);
    
    $stmt->execute();
    
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        http_response_code(200);
        echo json_encode([
            "message" => "Login successful",
            "user_id" => $row['id'],
            "username" => $row['username']
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Invalid username or password"]);
    }
    


?>