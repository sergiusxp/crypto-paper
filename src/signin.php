<?php

if(!isset($_SESSION)) session_start();
include_once('db.php');

if(isset($_POST) && count($_POST) > 0) {
    header('Content-Type: application/json');

    $username = $_POST['username'];
    $password = $_POST['password'];
    $failure = json_encode([ 'success' => false, 'message' => 'Username o password errati' ]);

    $sql = "SELECT * FROM accounts WHERE username = '$username'";
    $query = $db->query($sql);
    if($query->num_rows == 0) {
        die($failure);
    }

    $a = $query->fetch_object();
    $salt = $a->salt;
    $password_hash = md5($password . $salt);

    if ($password_hash == $a->password) {
        $_SESSION['id_account'] = $a->id_account;
        $_SESSION['admin'] = $a->admin;
        $_SESSION['username'] = $a->username;
        
        die(json_encode([ 'success' => true, 'message' => '' ]));
    } else {
        die($failure);
    }
}

?>
<link rel="stylesheet" href="css/signin.css">

<form>
    <h1>Accedi</h1>
    <div class="input-group">
        <label for="username">Nome utente:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="input-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" id="login-button">Login</button>
</form>
<div id="login-result"></div>

<script src="js/signin.js"></script>