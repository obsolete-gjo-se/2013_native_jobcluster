<?php
$title = 'Testaufgabe 4';
require_once '../application/bootstrap.php';
require_once '../application/includes/header.php';
require_once '../application/includes/navigation.php';

$errorMsg = '';
$originalText = '';
$shuffledText = '';

if (isset($_POST['submit'])) {

    $shuffleWords = new \controller\ShuffleWordsController();

    $shuffledText = $shuffleWords->getShuffledText();
    $originalText = $shuffleWords->getOriginalText();
    $errorMsg = $shuffleWords->getErrorMsg();
}
?>

<h2>Lösung zu Aufgabe 4</h2>
<p>Geben Sie einen beliebigen Text (max. 250 Zeichen a-z, A-Z und Sonderzeichen (öäüß) ein und wählen Sie würfeln.<br />
Das Original bleibt dabei in der Textbox erhalten.</p>

<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
    <label for="originalText">Text eingeben: </label>
    <textarea id="originalText" rows="7" cols="50" maxlength="255"
              name="originalText"><?php echo $originalText ?></textarea>

    <input type="submit" name="submit" value="Würfeln">
</form>
<p class="error_msg"><?php echo $errorMsg ?></p>

<?php if (isset($_POST['submit']) && $errorMsg == ''): ?>
<p><?php echo '<b>Würfeltext: </b><br/>' . $shuffledText; ?>
</p>

<?php endif; ?>

<?php require_once '../application/includes/footer.php';


/*
http://www.blindtextgenerator.de/
 */


?>

