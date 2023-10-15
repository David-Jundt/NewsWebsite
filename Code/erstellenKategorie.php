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
    <title>KategorieErstellen</title>
    <link rel="stylesheet" href="style.css">
    <form action="erstellenKategorie.php" method="post">

    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<body>
    <!--Navbar-->
    <?php
    include('navbar.php');
    ?>

    <h1 id="titel">Kategorie Erstellen</h1>

    <!--Formular fürs erstellen von Kategorien-->
    <div class="container">
        <label class="form-label">Kategorie erstellen:</label>
        <input type="text" class="form-control" name="kategorie" required="true" maxlength="20" placeholder="Kategorie eingeben...">
        <br>
        <button type="submit" name="button" value="submit" class="btn btn-info" id="button1">Kategorie Erstellen</button>
        <button type="reset" name="resetbtn" value="reset" class="btn btn-warning" id="button1">Clear</button>
    </div>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Schauen ob input nicht leer und ob länge nicht überschritten ist
            if (isset($_POST['kategorie']) && strlen($_POST['kategorie']) <= 20) {
                //Daten aus den input herausnehmen
                $kategorie = htmlspecialchars(trim($_POST['kategorie']));
            }
                //Daten werden in die Datenbank eingefügt
                $query = "Insert into kategories (kategorie) values (?)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('s', $kategorie);
                $stmt->execute();
                $mysqli->close();
            //header('Location: index.php');
        }
    ?>
    
    <!--bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </form>
</body>
</html>