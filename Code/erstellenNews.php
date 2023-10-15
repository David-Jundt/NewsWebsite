<?php
include('dbConnector.php');
if (!$_SESSION['loggedin']) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsErstellen</title>
    <link rel="stylesheet" href="style.css">
    <form action="erstellenNews.php" method="post">

    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<body>
    <!--Navbar-->
    <?php
    include('navbar.php');
    ?>

    <h1 id="titel">News Erstellen</h1>

    <!--Formular fürs erstellen von News-->
    <div class="container">
        <label class="form-label">Titel:</label>
        <input type="text" class="form-control" name="titel" required="true" maxlength="255" placeholder="Titel...">

        <label class="form-label">Inhalt:</label>
        <textarea class="form-control" rows="4" name="inhalt" required="true" maxlength="5000" placeholder="Schreiben sie ihren Text hier..."></textarea>

        <label class="form-label">Gültig von:</label>
        <input type="date" class="form-control" name="gueltigVon" required="true">

        <label class="form-label">Gültig bis:</label>
        <input type="date" class="form-control" name="gueltigBis" required="true">

        <?php
        //Aktuelle Zeit ermitteln
        $timestamp = time();
        $datum = date("d.m.Y", $timestamp);
        ?>
        <label class="form-label">Erstellungsdatum:</label>
        <?php
            echo "<input type='text' class='form-control' value=' $datum' name='erstelldatum' disabled readonly>";
        ?>
    
        <div class="dropdown">
            <label class="form-label">Kategorie:</label><br>
            <select name="kategorie" class="dropdown-toggle" id="dropdown1">
            <?php
                //Ausgabe von Kategorien in die Dropdownliste
                $query = "SELECT * from kategories";
                $result = mysqli_query($mysqli, $query);
        
                while($row = mysqli_fetch_array($result)) {
                    $kategorie = $row["kategorie"];

                    ?>
                        <option value="<?php echo $kategorie ?>"><?php echo $kategorie ?></option>
                    <?php
                }
            ?>
            </select>
        </div>

        <label class="form-label">Bild:</label>
        <input type="text" class="form-control" name="bild" required="true" maxlength="255" placeholder="Bildadresse einfügen...">

        <label class="form-label">Autor:</label>
        <input type="text" class="form-control" value="<?php echo $_SESSION['bname']; ?>" name="autor" disabled readonly>
        <br>
        <button type="submit" name="button" value="submit" class="btn btn-info" id="button1">News Erstellen</button>
        <button type="reset" name="resetbtn" value="reset" class="btn btn-warning" id="button1">Clear</button>
    </div>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Schauen ob inputs nicht leer und ob länge nicht überschritten sind
            if (isset($_POST['titel']) && isset($_POST['inhalt']) && isset($_POST['gueltigVon']) && isset($_POST['gueltigBis']) && isset($_POST['bild']) && strlen($_POST['titel']) <= 255 && strlen($_POST['inhalt']) <= 5000 && strlen($_POST['bild']) <= 255) {
                //Daten aus den inputs herausnehmen
                $titel = htmlspecialchars(trim($_POST['titel']));
                $inhalt = htmlspecialchars(trim($_POST['inhalt']));
                $gueltigVon = htmlspecialchars(trim($_POST['gueltigVon']));
                $gueltigBis = htmlspecialchars(trim($_POST['gueltigBis']));
                $kategorie = htmlspecialchars(trim($_POST['kategorie']));
                $bild = htmlspecialchars(trim($_POST['bild']));
                $autor = $_SESSION['bname'];
            }
            //ID von der Kategorie herausfinden
            $kid = 0;
            $selectKID = "SELECT kid from kategories where kategorie = '".$kategorie."'";
            $result = mysqli_query($mysqli, $selectKID);
            //ID vom Autor herausfinden
            $uid = 0;
            $selectUID = "SELECT uid from users where Benutzername = '".$autor."'";
            $result1 = mysqli_query($mysqli, $selectUID);

            while ($row = mysqli_fetch_array($result)) {
                $kid = $row['kid'];
                while ($row = mysqli_fetch_array($result1)) {
                    $uid = $row['uid'];
                
                    //Alle Daten werden in die Datenbank eingefügt
                    $query = "Insert into news (titel, inhalt, gueltigVon, gueltigBis, erstelltam, kid, autor, bild) values (?,?,?,?,NOW(),?,?,?)";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param('ssssiis', $titel, $inhalt, $gueltigVon, $gueltigBis, $kid, $uid, $bild);
                    $stmt->execute();
                    $mysqli->close();
                }
            }
            header('Location: index.php');
        }
    ?>
    
    <!--bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </form>
</body>
</html>