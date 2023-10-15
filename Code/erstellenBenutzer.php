<?php
include('dbConnector.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BenutzerErstellen</title>
    <link rel="stylesheet" href="style.css">
    <form action="erstellenBenutzer.php" method="post">

    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<body>
    <!--Navbar-->
    <?php
    include('navbar.php');
    ?>

    <h1 id="titel">Registrierung</h1>

    <!--Formular fürs erstellen von Benutzern-->
    <div class="container">
        <label class="form-label">Benutzername:</label>
        <input type="text" class="form-control" name="benutzername" required="true" maxlength="20" placeholder="Benutzernamen eingeben...">

        <label class="form-label">Passwort:</label>
        <input type="password" class="form-control" name="passwort" required="true" maxlength="255" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Passwort eingeben...">
        <small>mind. 8 Zeichen, Gross-Kleinschreibung, mind. eine Zahl und Sonderzeichen</small><br>

        <label class="form-label">Anrede:</label><br>
        <label id="label1" >Herr: </label>
        <input type="radio" name="anrede" value="Herr" checked>
        <label id="label1">Frau: </label>
        <input type="radio" name="anrede" value="Frau"><br>

        <label class="form-label">Vorname:</label>
        <input type="text" class="form-control" name="vorname" required="true" maxlength="50" placeholder="Vornamen eingeben...">

        <label class="form-label">Nachname:</label>
        <input type="text" class="form-control" name="nachname" required="true" maxlength="50" placeholder="Nachname eingeben...">

        <label class="form-label">Strasse:</label>
        <input type="text" class="form-control" name="strasse" required="true" maxlength="50" placeholder="Strasse eingeben...">

        <label class="form-label">PLZ:</label>
        <input type="text" class="form-control" name="plz" required="true" maxlength="15" placeholder="PLZ eingeben...">

        <label class="form-label">Ort:</label>
        <input type="text" class="form-control" name="ort" required="true" maxlength="50" placeholder="Ort eingeben...">

        <label class="form-label">Land:</label>
        <input type="text" class="form-control" name="land" required="true" maxlength="50" placeholder="Land eingeben...">

        <label class="form-label">E-Mail:</label>
        <input type="email" class="form-control" name="email" required="true" maxlength="30" placeholder="E-Mail eingeben...">

        <label class="form-label">Telefonnummer:</label>
        <input type="number" class="form-control" name="telefonnummer" required="true" maxlength="11" placeholder="Telefonnummer eingeben...">
        <br>
        <button type="submit" name="button" value="submit" class="btn btn-info" id="button1">Benutzer Erstellen</button>
        <button type="reset" name="resetbtn" value="reset" class="btn btn-warning" id="button1">Clear</button>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Schauen ob inputs nicht leer und ob länge nicht überschritten sind
        if (isset($_POST['benutzername']) && isset($_POST['passwort']) && isset($_POST['anrede']) && isset($_POST['vorname']) && isset($_POST['nachname']) && isset($_POST['strasse']) && isset($_POST['plz']) && isset($_POST['ort']) && isset($_POST['land']) && isset($_POST['email']) && isset($_POST['telefonnummer'])) {
            if (strlen($_POST['benutzername']) <= 20 && strlen($_POST['passwort']) <= 255 && strlen($_POST['vorname']) <= 50 && strlen($_POST['nachname']) <= 50 && strlen($_POST['strasse']) <= 50 && strlen($_POST['plz']) <= 15 && strlen($_POST['ort']) <= 50 && strlen($_POST['land']) <= 50 && strlen($_POST['email']) <= 30 && strlen($_POST['telefonnummer']) <= 11) {
                //Daten aus den inputs herausnehmen
                $benutzername = htmlspecialchars(trim($_POST['benutzername']));
                $passwort = htmlspecialchars(trim($_POST['passwort']));
                $anrede = htmlspecialchars(trim($_POST['anrede']));
                $vorname = htmlspecialchars(trim($_POST['vorname']));
                $nachname = htmlspecialchars(trim($_POST['nachname']));
                $strasse = htmlspecialchars(trim($_POST['strasse']));
                $plz = htmlspecialchars(trim($_POST['plz']));
                $ort = htmlspecialchars(trim($_POST['ort']));
                $land = htmlspecialchars(trim($_POST['land']));
                $email = htmlspecialchars(trim($_POST['email']));
                $telefonnummer = htmlspecialchars(trim($_POST['telefonnummer']));

                //Passwort wird mit salt gehashed
                $hashedPw = password_hash($passwort, PASSWORD_DEFAULT, ['salt' => '$P27r06o9!nasda57b2M22']);
            }
        }
        //Alle Daten werden in die Datenbank eingefügt
        $query = "Insert into users (Benutzername, Passwort, Anrede, Vorname, Nachname, Strasse, PLZ, Ort, Land, EMail_Adresse, Telefon) values (?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ssssssssssi', $benutzername, $hashedPw, $anrede, $vorname, $nachname, $strasse, $plz, $ort, $land, $email, $telefonnummer);    
        $stmt->execute();       
        $mysqli->close();

        header('Location: login.php');

    }
    ?>

    <!--bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </form>
</body>
</html>