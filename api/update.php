<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
    header('Allow: PUT');
    http_response_code(405);
    echo json_encode('Method Not Allowed');
    return;
}

include_once '../db/Database.php';
include_once '../models/bookmark.php';

// Instantiate a Database object & connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate bookmark object
$bookmark = new bookmark($dbConnection);

// Get the HTTP PUT request JSON body
$data = json_decode(file_get_contents("php://input"));
if (!$data || !$data->id) { // ID Required
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: Missing required parameter id.')
    );
    return;
}

$bookmark->setId($data->id);

if (isset($data->title) || isset($data->link)) {
    if (isset($data->title)) {
        $bookmark->setTitle($data->title);
    }
    if (isset($data->link)) {
        $bookmark->setLink($data->link);
    }

}

// Update the bookmark item
if ($bookmark->update()) {
    echo json_encode(
        array('message' => 'A bookmark item was updated.')
    );
} else {
    echo json_encode(
        array('message' => 'Error: a bookmarks item was not updated.')
    );
}

