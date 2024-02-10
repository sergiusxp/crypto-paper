<?php

if(!isset($_SESSION)) session_start();
include_once('db.php');

$type = "WHERE ";
if(isset($_SESSION['admin']) && $_SESSION['admin'] == '1') {
    $type .= "section_type <> 'only_unregistered'";
} else {
    $type .= !isset($_SESSION['id_account']) ? "section_type IN ('public', 'only_unregistered')" : "section_type IN ('public', 'only_registered')";
}

$sql = "SELECT * FROM sections s $type ORDER BY s.order ASC";
$result = $db->query($sql);

$name = "";
if(isset($_SESSION['id_account'])) {
    $name = ", " . $_SESSION['username'];
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Homepage Cifrature</title>
    <link rel="stylesheet" href="css/home.css?rnd=<?=time()?>">
    <link rel="stylesheet" href="css/forms.css?rnd=<?=time()?>">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <span style="padding: 10px">Benvenuto<?=$name?></span>
            <ul>
                <li tit="index" onclick="goToHome();">Homepage</li>
                <?php while($a = $result->fetch_object()) { ?>
                <li tit="<?=$a->section_tit?>" onclick="caricaPagina('<?=$a->url?>', '<?=$a->section_tit?>')"><?=$a->name?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="content" id="content">
            Benvenuto<?=$name?>! Clicca su una cifratura per iniziare.
        </div>
    </div>

    <!-- Vulnerable library -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-rc1/jquery.js"></script> -->
    <!-- Fix -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Other imports -->
    <script src="js/home.js?rnd=<?=time()?>"></script>
    <script src="js/comments.js?rnd=<?=time()?>"></script>
</body>
</html>
