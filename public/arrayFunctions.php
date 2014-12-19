<?php
$title = 'Testaufgabe 1 - MySQL';
require_once '../application/bootstrap.php';
require_once '../application/includes/header.php';
require_once '../application/includes/navigation.php';
?>

<p>array_flip() vertauscht die Schlüssel/Werte-Paare und LÖSCHT doppelte Schlüssel,
    array_keys() gibt damit unique Schlüssel zurück, die beim zählen notwenig sind
</p>
<p>array_unique() entfernt zwar die doppelten Werte, BELÄSST aber die Schlüssel im Array,
    Zählwerte würden somit falsche Ergebnisse liefern.</p>



<?php require_once '../application/includes/footer.php';?>
