<?php

if(!isset($_SESSION)) session_start();
include_once('db.php');

if(isset($_POST) && count($_POST) > 0) {
    header('Content-Type: application/json');

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($username == "" || $email == "" || $password == "") {
        die(json_encode([ 'success' => false, 'message' => 'Compila tutti i campi' ]));
    }

    $failure = json_encode([ 'success' => false, 'message' => 'L\'username o l\'indirizzo e-mail esistono gia.' ]);

    $sql = "SELECT * FROM accounts WHERE username = '$username' OR email = '$email'";
    $query = $db->query($sql);
    if($query->num_rows > 0) {
        die($failure);
    }

    $salt = md5(uniqid());
    $password = md5($password . $salt);

    $sql = "INSERT INTO accounts (username, email, password, salt, admin) VALUES ('$username', '$email', '$password', '$salt', b'0')";
    $db->query($sql);

    if($db->errno) {
        die(json_encode([ 'success' => false, 'message' => 'Errore durante la registrazione: ' . $db->error ]));
    }

    die(json_encode([ 'success' => true, 'message' => '' ]));
}

?>
<link rel="stylesheet" href="css/signin.css">

<form>
    <h1>Registrati</h1>
    <div class="input-group">
        <label for="username">Nome utente:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="input-group">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="input-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" id="signup-button">Registrati</button>
</form>
<div id="signup-result"></div>

<script src="js/signup.js"></script>