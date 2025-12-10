<?php
header("Content-Type: application/json; charset=utf-8");

// File chứa danh sách key
$file = "device_keys.txt";

if (!file_exists($file)) {
    echo json_encode(["status" => "denied", "msg" => "NO_DATABASE"]);
    exit;
}

$device = $_GET["device"] ?? "";
if ($device == "") {
    echo json_encode(["status" => "denied", "msg" => "NO_DEVICE"]);
    exit;
}

$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    list($key, $expire) = explode("|", trim($line));

    if ($key == $device) {
        if (time() > intval($expire)) {
            echo json_encode(["status" => "expired", "msg" => "KEY_EXPIRED"]);
            exit;
        }

        echo json_encode(["status" => "allowed", "msg" => "OK"]);
        exit;
    }
}

echo json_encode(["status" => "denied", "msg" => "DEVICE_NOT_FOUND"]);

