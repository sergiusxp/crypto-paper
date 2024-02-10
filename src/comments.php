<?php

if(!isset($_SESSION)) session_start();
include_once('db.php');

$id_section = $_GET["id"];
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] == 1;

if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $rawData = file_get_contents("php://input");
    parse_str($rawData, $data);
    $id_comment = $data["id_comment"];
    $id_account = $_SESSION["id_account"];

    if(!$isAdmin) {
        $sqlcheck = "SELECT * FROM comments WHERE id_comment = $id_comment AND id_account = $id_account";
        $querycheck = $db->query($sqlcheck);
        if($querycheck->num_rows == 0) {
            die(json_encode([ 'success' => false, 'message' => "Non puoi eliminare un commento che non ti appartiene o che non esiste." ]));
        }
    }

    $sql = "DELETE FROM comments WHERE id_comment = $id_comment AND id_account = $id_account";
    $db->query($sql);

    if($db->errno) {
        die(json_encode([ 'success' => false, 'message' => "Errore durante l'eliminazione del commento: " . $db->error ]));
    }

    die(json_encode([ 'success' => true, 'message' => '' ]));
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = addslashes($_POST["commento"]);
    $id_account = $_SESSION["id_account"];

    $sql = "INSERT INTO comments (text, id_account, id_section) VALUES ('$text', $id_account, (SELECT id_section FROM sections WHERE section_tit = '" . $id_section . "'))";
    $db->query($sql);

    if($db->errno) {
        die(json_encode([ 'success' => false, 'message' => "Errore durante l'inserimento del commento: " . $db->error ]));
    }

    die(json_encode([ 'success' => true, 'message' => '' ]));
}

$sql = "SELECT c.*, s.name, a.username FROM (comments c INNER JOIN accounts a ON c.id_account = a.id_account) INNER JOIN sections s ON c.id_section = s.id_section WHERE s.section_tit = '" . $_GET["id"] . "' ORDER BY datetime DESC";
$result = $db->query($sql);

?>
<div class="comments-container">
    <h1>Commenti</h1>
    <input type="hidden" value="<?=$_GET["id"]?>" id="page-id">
    <?php if(isset($_SESSION["id_account"])) { ?>
        <div class="comment-form">
            <textarea id="new-comment-text" placeholder="Scrivi un commento..."></textarea>
            <br><br>
            <button id="add-comment-button">Aggiungi Commento</button>
        </div>
        <?php if ($result->num_rows > 0) { ?>
        <br><br>
        <div class="comments-list">
            <?php while($a = $result->fetch_object()) { ?>
            <?php
                $myCmt = $_SESSION['id_account'] == $a->id_account;
            ?>
            <div class="comment">
                <p class="comment-author"><i>Autore</i>: <?=$a->username?></p>
                <p class="comment-date"><i>Data</i>: <?=date("d/m/Y H:i", strtotime($a->datetime));?></p>
                <?php if($isAdmin || $myCmt) { ?>
                    <i><?=$myCmt ? "Azioni" : "Admin"?></i>: <span class="deleteCmt" onclick="dropComment('<?=$id_section?>', <?=$a->id_comment?>)">Elimina</span>
                <?php } ?>
                <p class="comment-body"><i>Commento</i>: <span cid="<?=$a->id_comment?>" class="cmt-body"><?=$a->text?></span></p>
            </div>
            <?php } ?>
        </div>
        <?php } else { echo "<p>Nessun commento presente.</p>"; } ?>
    <?php } else echo "Solo gli utenti registrati hanno accesso alla sezione commenti. Registrati o fai il login."; ?>
</div>