<?php
$title = 'Testaufgabe 3';
require_once '../application/bootstrap.php';
require_once '../application/includes/header.php';
require_once '../application/includes/navigation.php';

$agencyNumber = '';
$birthdayForForm = '';
$expirationForForm = '';
$errorMsg = '';

if(isset($_POST['submit'])){

    $passportNumber = new controller\PassportnumberController();

    $agencyNumber = $passportNumber->getAgencyNumber();
    $serialNumber = $passportNumber->getSerialNumber();
    $agencySerialCheckSum = $passportNumber->getChecksum($agencyNumber . $serialNumber);
    $nationality = $passportNumber->getNationality();

    $birthdayForForm = $passportNumber->getBirthdayForForm();
    $birthdayOutput = $passportNumber->getBirthdayOutput();
    $birthdayCheckSum = $passportNumber->getChecksum($birthdayOutput);

    $expirationForForm = $passportNumber->getExpirationDateForForm();
    $expirationOutput = $passportNumber->getExpirationDateOutput();
    $expirationCheckSum = $passportNumber->getChecksum($expirationOutput);

    $totalCheckSum = $passportNumber->getChecksum($agencyNumber . $serialNumber . $agencySerialCheckSum . $birthdayOutput .
        $birthdayCheckSum . $expirationOutput . $expirationCheckSum);

    $errorMsg = $passportNumber->getErrorMsg();
}
?>

<h2>Lösung zu Aufgabe 3</h2>
<p>Alle Felder müssen ausgefüllt werden.</p>

<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
    <label for="agencyNumber">Behördenkennzahl: </label>
    <input type="text" id="agencyNumber" name="agencyNumber" size="4" maxlength="4" placeholder="0000"
           value="<?php echo $agencyNumber;?>">

    <label for="birthday">Geburtsdatum: </label>
    <input type="text" id="birthday" name="birthday" size="10" maxlength="10" placeholder="TT.MM.JJJJ"
           value="<?php echo $birthdayForForm;?>">

    <label for="expirationDate">Ablaufdatum: </label>
    <input type="text" id="expirationDate" name="expirationDate" size="10" maxlength="10" placeholder="TT.MM.JJJJ"
           value="<?php echo $expirationForForm;?>">

    <input type="submit" name="submit" value="Ausweisnummer generieren">
</form>
<p class="error_msg"><?php echo $errorMsg ?></p>

<?php if (isset($_POST['submit']) && !$errorMsg): ?>
<p><?php echo 'Ausweisnummer: ' . $agencyNumber . $serialNumber . $agencySerialCheckSum . $nationality . '<<' .
    $birthdayOutput . $birthdayCheckSum . '<' . $expirationOutput . $expirationCheckSum . '<<<<<<<' . $totalCheckSum; ?>
</p>

<?php endif;?>
<?php require_once '../application/includes/footer.php';?>

