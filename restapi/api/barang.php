<?php
include "../config/koneksi.php";
header("Content-Type: application/json; charset=utf-8");


//Dhany Gracia Suryana Lero
//23040166


$path = "";
$script = $_SERVER['SCRIPT_NAME'];
$uri = $_SERVER['REQUEST_URI'];
if (strpos($uri, $script) == 0) {
    $path = trim(substr($uri, strlen($script)), '/');
} else {
    $parts = explode('barang.php', $uri);
    $path = isset($parts[1]) ? trim($parts[1], '/ ') : '';
}
$segments = $path == "" ? array() : explode('/', $path);
$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'GET') {
    respond(array("status" => "error", "code" => 405, "message" => "Method notc
allowed"), 405);
}

if (count($segments) == 0) {
    $sql = "SELECT * FROM tb_barang";
    $res = mysqli_query($koneksi, $sql);
    if ($res == false) {
        respond(array("status" => "error", "code" => 500, "message" => "Query
error: " . mysqli_error($koneksi)), 500);
    }
    $data = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    respond(
        array("status" => "success", "code" => 200, "data" => $data),
        200
    );
}

if (
    count($segments) >= 2 && strtolower($segments[0]) === 'id' &&
    is_numeric($segments[1])
) {
    $id = (int)$segments[1];
    $sql = "SELECT * FROM tb_barang WHERE id_barang = " . $id;
    $res = mysqli_query($koneksi, $sql);
    if ($res == false) {
        respond(array("status" => "error", "code" => 500, "message" => "Query
error: " . mysqli_error($koneksi)), 500);
    } else {
        $data = mysqli_fetch_assoc($res);
        respond(
            array("status" => "success", "code" => 200, "data" => $data),
            200
        );
    }
}
function respond($payload, $httpCode = 200)
{
    http_response_code($httpCode);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

respond(["status" => "error", "code" => 400, "message" => "Endpoint tidak
valid"], 400);



//Dhany Gracia Suryana Lero
//23040166