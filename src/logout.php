<?php

if(!isset($_SESSION)) session_start();
include_once('db.php');

session_regenerate_id(true);
session_unset();
session_destroy();
session_start();

?>
Logout riuscito. Redirect in 2 secondi...
<script>
    setTimeout(function() {
        goToHome();
    }, 2000);
</script>