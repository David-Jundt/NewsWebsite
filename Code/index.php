<?php
include('dbConnector.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
    <form action="index.php" method="post">

    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<body>
    <!--Navbar-->
    <?php
    include('navbar.php');
    ?>
    
    <h1 id="titel">Homepage</h1>
    <form action="index.php" method="post">
    <div class="dropdown" id="sort1">
        <label class="form-label" id="sort1">Sortieren:</label><br>
        <select name="kategorie" class="dropdown-toggle" id="sort1">
            <option value=""> - </option>
        <?php
            //Ausgabe von Kategorien in die Dropdownliste
            $query = "SELECT * from kategories";
            $result = mysqli_query($mysqli, $query);
    
            while($row = mysqli_fetch_array($result)) {
                $kategorie = $row["kategorie"];
                $kid = $row["kid"];
                ?>
                    <option value="<?php echo $kid ?>"><?php echo $kategorie ?></option>
                <?php
            }

        ?>
        </select>
        <button type="submit" name="button" value="submit" class="btn btn-info" id="button2">Sortieren</button>
  
    </div>
    </form>

    <div class="container text-center">
        <div class="row row-cols-2">
    <?php
        $filter = "";
        $filterSTR = "";
        
        //Vorbereitung für Sortierung nach Kategorien
        if ($_SERVER["REQUEST_METHOD"] == "POST") { 
            if ($_POST['kategorie'] == "-") {
                $filter = "";
            } else {
                $filter = $_POST['kategorie'];
                $filterSTR = " where kid = ";
            }
            if ($filter == "") {
                $filterSTR = "";
            }
        }

        //Ausgabe des ganzen Tables news||Sortierung nach Kategorien||Sortierung nach Erstelldatum
        $query = "SELECT * from news".$filterSTR.$filter." order by erstelltam DESC";
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

            //Ausgabe von den News die nicht abgelaufen sind
            $timestamp = time();
            $datum = date("d.m.Y", $timestamp);
            $datumBis = strtotime($gueltigBis);
            $datumJetzt = strtotime($datum);
            if ($datumBis >= $datumJetzt) {

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
                <!-- Ausgabe der News -->
                <div class="col bg-dark text-white rounded border border-white" id="column1">
                    <h4><?php echo $titel ?></h4>
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
        } 

        //Sessions
        $_SESSION['limit1'] = 0;
        $_SESSION['limit2'] = 5;
        $_SESSION['num'] = 1;
        $_SESSION['counter'] = 0;

    ?>
        </div>
    </div>
    
    <!--bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </form>
</body>
</html>