<?php
header("Access-Control-Allow-Origin: *"); // Allow React app
header("Access-Control-Allow-Methods: POST"); // Allow POST and preflight OPTIONS
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: Application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('ALLOW: POST');
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
    exit;
}


include_once '../db/Database.php';
include_once '../models/bookmark.php';

$database = new Database();
$dbConnection = $database->connect();

$bookmark = new bookmark($dbConnection);
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['title']) || !isset($data['link'])) {
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: Missing required parameter task in the JSON body.')
    );
    return;
}

$bookmark->settitle($data['title']);
$bookmark->setlink($data['link']);

if ($bookmark->create()) {
    echo json_encode(
        array('message' => 'A bookmark item was created')
    );
} else {
    echo json_encode(
        array('message' => 'Error: a bookmark item was not created')
    );
}
