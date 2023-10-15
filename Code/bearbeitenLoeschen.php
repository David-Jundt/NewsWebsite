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
    <title>NewsLöschen</title>
    <link rel="stylesheet" href="style.css">
    <form action="bearbeitenLoeschen.php" method="post">

    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<body>
    <!--Navbar-->
    <?php
    include('navbar.php');
    ?>

    <h1 id="titel">News Löschen</h1>

    <!--Formular fürs löschen von News-->
    <div class="container text-center">
        <div class="row row-cols-2">
    <?php
        //Ausgeben und Sortieren nach autor
        $query = "SELECT * FROM news where autor = '".$_SESSION['bnameInt']."'";
        $result = mysqli_query($mysqli, $query);

        while($row = mysqli_fetch_array($result)) {
            $titel = $row['titel'];
            $erstelltam = $row['erstelltam'];
            $newsID = $row['newsID'];
            $uid = $row['autor'];

            //get Autorenname
            $autorName = "SELECT Benutzername from users where uid = ".$uid;
            $result2 = mysqli_query($mysqli, $autorName);

            while ($row = mysqli_fetch_array($result2)) {      
                $autorName = $row['Benutzername'];
            }
    ?>
            <!-- Ausgabe der News -->
            <div class="col bg-dark text-white rounded border border-white" id="column1">
                <h4><?php echo $titel ?></h4>
                <strong>Erstellungsdatum:</strong>
                <?php echo $erstelltam; ?>
                <br>
                <strong>News ID:</strong>
                <?php echo $newsID; ?> 
                <strong>||</strong>
                <strong>Autor:</strong>
                <?php echo $autorName; ?>
                <br>
                <br>
                <button type="submit" name="loeschen" value="<?php echo $newsID; ?>" class="btn btn-info">&#x1F5D1;</button>
                <button type="submit" name="bearbeiten" value="<?php echo $newsID; ?>" class="btn btn-info">Bearbeiten</button>
            </div>
    <?php            
        } 
    ?>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['loeschen'])) {
            $newsID = htmlspecialchars(trim($_POST['loeschen']));
            //Löscht die ausgewählte News
            $query = "DELETE FROM news WHERE newsID = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("i", $newsID);
            $stmt->execute();
        } elseif (isset($_POST['bearbeiten'])) {
            $newsID = htmlspecialchars(trim($_POST['bearbeiten']));
            //Ausgabe des ganzen Tables news wo newsID = $newsID
            $query = "SELECT * from news where newsID = '".$newsID."'";
            //Session
            $_SESSION['newsID'] = $newsID;

            $result = mysqli_query($mysqli, $query);
            while($row = mysqli_fetch_array($result)) {
                $titel = $row['titel'];
                $kid = $row['kid'];
                $inhalt = $row['inhalt'];
                $gueltigVon = $row['gueltigVon'];
                $gueltigBis = $row['gueltigBis'];
                $erstelltam = $row['erstelltam'];
                $bild = $row['bild'];
                $uid = $row['autor'];
                //get Kategoriename
                $kategorieName = "SELECT kategorie from kategories where kid = ".$kid;
                $result1 = mysqli_query($mysqli, $kategorieName);
                //get Autorenname
                $autorName = "SELECT Benutzername from users where uid = ".$uid;
                $result2 = mysqli_query($mysqli, $autorName);

                while ($row = mysqli_fetch_array($result1)) {
                    $kategorieName = $row['kategorie']; 
                }

                while ($row = mysqli_fetch_array($result2)) {      
                    $autorName = $row['Benutzername'];
                }
    ?>
                <div class="row justify-content-md-center">
                    <div class="col bg-dark text-white text-center rounded border border-white col-lg-2" id="column1">
                        <div class="container">
                            <label class="form-label">Titel:</label>
                            <input type="text" class="form-control" name="titel" required="true" maxlength="255" value="<?php echo $titel; ?>">

                            <label class="form-label">Inhalt:</label>
                            <textarea class="form-control" rows="4" name="inhalt" required="true" maxlength="5000"><?php echo $inhalt; ?></textarea>

                            <label class="form-label">Gültig von:</label>
                            <input type="date" class="form-control" name="gueltigVon" required="true" value="<?php echo $gueltigVon; ?>">

                            <label class="form-label">Gültig bis:</label>
                            <input type="date" class="form-control" name="gueltigBis" required="true" value="<?php echo $gueltigBis; ?>">

                            <label class="form-label">Erstellungsdatum:</label>
                            <input type="date" class="form-control" name="erstelltam" required="true" value="<?php echo $erstelltam; ?>" disabled readonly>
                        
                            <div class="dropdown">
                                <label class="form-label">Kategorie:</label><br>
                                <select name="kategorie" class="dropdown-toggle">
                                <?php
                                    //Ausgabe von Kategorien in die Dropdownliste
                                    $query = "SELECT * from kategories";
                                    $result = mysqli_query($mysqli, $query);
                                    ?>
                                    <option value="<?php echo $kategorieName; ?>"><?php echo $kategorieName; ?></option>
                                    <?php
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
                            <input type="text" class="form-control" name="bild" required="true" maxlength="255" value="<?php echo $bild; ?>">

                            <label class="form-label">Autor:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['bname']; ?>" name="autor" disabled readonly>
                            <br>
                            <button type="submit" name="bearbeiten1" class="btn btn-info" id="buttonUpdate">Bearbeiten Ausführen</button>
                        </div>
                    </div>
                </div>
    <?php
            }
        }

        if (isset($_POST['bearbeiten1'])){
            if(isset($_POST['titel']) && isset($_POST['inhalt']) && isset($_POST['gueltigVon']) && isset($_POST['gueltigBis']) && isset($_POST['bild']) && strlen($_POST['titel']) <= 255 && strlen($_POST['inhalt']) <= 5000 && strlen($_POST['bild']) <= 255){
                $titel = htmlspecialchars(trim($_POST['titel']));
                $inhalt = htmlspecialchars(trim($_POST['inhalt']));
                $gueltigVon = htmlspecialchars(trim($_POST['gueltigVon']));
                $gueltigBis = htmlspecialchars(trim($_POST['gueltigBis']));
                $kategorieName = htmlspecialchars(trim($_POST['kategorie']));
                $bild = htmlspecialchars(trim($_POST['bild']));
                //ID von der Kategorie herausfinden
                $kid = 0;
                $selectKID = "SELECT kid from kategories where kategorie = '".$kategorieName."'";
                $result = mysqli_query($mysqli, $selectKID);

                while ($row = mysqli_fetch_array($result)) {
                    $kid = $row['kid'];
                    //Alte Daten werden mit neuen Daten überschrieben
                    $query = "UPDATE news set titel = '".$titel."', inhalt = '".$inhalt."', gueltigVon = '".$gueltigVon."', gueltigBis = '".$gueltigBis."', kid = '".$kid."', bild = '".$bild."' where newsID = '".$_SESSION['newsID']."'";
                    $stmt = $mysqli->prepare($query);
                    $stmt->execute();
                    $mysqli->close();
                }
            }
        }
        header("Refresh:0");
    }
    ?>

    <!--bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </form>
</body>
</html>