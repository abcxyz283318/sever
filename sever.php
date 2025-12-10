<?php
header("Content-Type: application/json; charset=utf-8");

$device = $_POST["device"] ?? "";
$days = intval($_POST["days"] ?? 0);

if ($device == "" || $days <= 0) {
    echo json_encode(["status" => "error", "msg" => "Missing data"]);
    exit;
}

$expire = time() + ($days * 86400);  // thời gian hết hạn
$file = "device_keys.txt";

// Lưu key dạng KEY|TIMESTAMP
$line = $device . "|" . $expire . PHP_EOL;
file_put_contents($file, $line, FILE_APPEND);

echo json_encode([
    "status" => "success",
    "device" => $device,
    "expire" => $expire
]);
