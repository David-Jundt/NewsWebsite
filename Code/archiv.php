<?php
include('dbConnector.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsErstellen</title>
    <link rel="stylesheet" href="style.css">
    <form action="archiv.php" method="post">

    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<body>
    <!--Navbar-->
    <?php
    include('navbar.php');
    ?>

    <h1 id="titel">Archiv</h1>

    <div class="container text-center">
        <div class="row row-cols-2">

    <?php
    //Blättern im archiv
    if (isset($_POST['naechste']) && $_SESSION['limit1'] <= $_SESSION['counter']) {
        $_SESSION['limit1'] += 5;
        $_SESSION['num']++;
    } elseif (isset($_POST['zurueck']) && $_SESSION['limit1'] > 4) {
        $_SESSION['limit1'] -= 5;
        $_SESSION['num']--;
    } else {
        $_SESSION['limit1'];
        $_SESSION['num'];
    }
    //Ermittelt das heutige Datum
    $timestamp = time();
    $datum = date("Y-m-d", $timestamp);

    //sortiert DESC||sortiert nach abgelaufene||gibt alles restliche von news aus
    $query = "SELECT * FROM news where gueltigBis < '".$datum."' order by gueltigBis DESC limit ".$_SESSION['limit2']." offset ".$_SESSION['limit1']."";
    $result = mysqli_query($mysqli, $query);

    while($row = mysqli_fetch_array($result)) {
        $titel = $row['titel'];
        $kid = $row['kid'];
        $inhalt = $row['inhalt'];
        $gueltigVon = $row['gueltigVon'];
        $gueltigBis = $row['gueltigBis'];
        $erstelltam = $row['erstelltam'];
        $newsID = $row['newsID'];
        $bild = $row['bild'];
        $uid = $row['autor'];

        //SESSION
        $_SESSION['counter']++;

        //get Kategorienname
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
            <div class="col bg-dark text-white rounded border border-white" id="column1">
                <h4><?php echo $titel; ?></h4>
                <strong>Kategorie:</strong>
                <?php echo $kategorieName; ?>
                <br>
                <br>
                <?php echo $inhalt; ?>
                <br>
                <img src="<?php echo $bild; ?>">
                <br>
                <strong>Gültig von:</strong>
                <?php echo $gueltigVon; ?>
                <br>
                <strong>Gültig bis:</strong>
                <?php echo $gueltigBis; ?>
                <br>
                <strong>Erstellungsdatum:</strong>
                <?php echo $erstelltam; ?>
                <br>
                <strong>News ID:</strong>
                <?php echo $newsID; ?> 
                <strong>||</strong>
                <strong>Autor:</strong>
                <?php echo $autorName; ?> 
            </div>
    <?php

    }  
    ?> 
        </div>
    </div>
            
    <div class="container">
        <button type="submit" name="zurueck">Zurück</button>
        <button type="submit" name="naechste">Nächste</button>
        <h5>Seite: <?php echo $_SESSION['num']; ?></h5>
    </div>

    <!--bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </form>
</body>
</html>