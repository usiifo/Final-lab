<?php
// Headers
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include_once '../db/Database.php';
include_once '../models/bookmark.php';

// Instantiate a Database object & connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate bookmark object
$bookmark = new bookmark($dbConnection);

$data = json_decode(file_get_contents("php://input"));
if(!$data || !$data->id){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: Missing required parameter id in the JSON body.')
    );
    return;
}

$bookmark->setId($data->id);

// Delete the bookmark item
if ($bookmark->delete()) {
    echo json_encode(
        array('message' => 'A bookmark item was deleted.')
    );
} else {
    echo json_encode(
        array('message' => 'Error: a bookmark item was not deleted.')
    );
}

