<?php
include('dbconnector.php');
if (!$_SESSION['loggedin']) {
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>passwortAendern</title>
    <link rel="stylesheet" href="style.css">
	  <form action="passwortAendern.php" method="post">
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

  </head>
  <body>
    <!--Navbar-->
    <?php
    include('navbar.php');
    ?>

    <h1 id="titel">Passwort Ändern</h1>

    <!--Formular fürs ändern vom Passwort-->
    <div class="container">
      <label class="form-label">Jetztiges Passwort:</label>
      <input type="password" class="form-control" name="altesPasswort" required="true" maxlength="255" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Jetztiges Passwort eingeben...">

      <label class="form-label">Passwort:</label>
      <input type="password" class="form-control" name="passwort" required="true" maxlength="255" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Passwort eingeben...">
      <small>mind. 8 Zeichen, Gross-Kleinschreibung, mind. eine Zahl und Sonderzeichen</small>
      <br>
      <button type="submit" name="button" value="submit" class="btn btn-info" id="button1">Login</button>
      <button type="reset" name="resetbtn" value="reset" class="btn btn-warning" id="button1">Clear</button>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      //Schauen ob inputs nicht leer und ob länge nicht überschritten sind
      if (isset($_POST['altesPasswort']) && isset($_POST['passwort']) && strlen($_POST['altesPasswort']) <= 255 && strlen($_POST['passwort']) <= 255) {
        $altesPasswort = htmlspecialchars(trim($_POST['altesPasswort']));
        $passwort = htmlspecialchars(trim($_POST['passwort']));
      }
      //Überprüfung ob die Daten den Anforderungen Entsprechen
      if(!preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}/", $altesPasswort) && !preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}/", $passwort)){
        //Findet Passwort vom Benutzer aus der Datenbank
        $hashedPW = "SELECT Passwort from users where Benutzername = '".$_SESSION['bname']."'";
        $result = mysqli_query($mysqli, $hashedPW);

        while ($row = mysqli_fetch_array($result)) { 
          //Schaut ob eingegebenes passwort mit gehashtem Passwort aus Datenbank übereinstimmt.
          if(password_verify($altesPasswort, $row['Passwort'])){
            //Hasht das neu eingegebene Passwort
            $hashedPwNew = password_hash($passwort, PASSWORD_DEFAULT);
            //Überschreibt das alte Passwort mit dem neuen
            $query = "UPDATE users set Passwort = '".$hashedPwNew."' where Benutzername = '".$_SESSION['bname']."'";
            $stmt = $mysqli->prepare($query);
            $stmt->execute();
            $mysqli->close();
          } else if(!password_verify($altesPasswort, $row['Passwort'])){
            echo "Das zurzeit aktive Passwort wurde falsch eingegeben.";
            break;
          }
        }
      }
    }

    ?>

    <!--bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
		</form>
  </body>
</html>