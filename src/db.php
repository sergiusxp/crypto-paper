<?php

$db = new mysqli("localhost", "root", "", "crypto");
if ($db -> connect_errno) {
    echo "Errore durante la connessione a MySQL: " . $db -> connect_error;
    exit();
}