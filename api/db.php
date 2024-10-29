<?php 

$host = $_ENV['PG_HOST'];
$port = $_ENV['PG_PORT'];
$db = $_ENV['PG_DB'];
$user = $_ENV['PG_USER'];
$password = $_ENV['PG_PASSWORD'];

$connection_string = "host=" . $host . " port=" . $port . " dbname=" . $db . " user=" . $user . " password=" . $password . " sslmode=require";

$dbconn = pg_connect($connection_string);

if (!$dbconn) {
    die("Connection failed: " . pg_last_error());
}
echo "Connected successfully";
