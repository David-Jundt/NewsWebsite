<?php
include('dbconnector.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
	  <form action="login.php" method="post">
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

  </head>
  <body>
    <!--Navbar-->
    <?php
    include('navbar.php');
    ?>

    <h1 id="titel">Login</h1>

    <!--Formular fürs Login-->
    <div class="container">
      <label class="form-label">Benutzername:</label>
      <input type="text" class="form-control" name="benutzername" required="true" maxlength="20" placeholder="Benutzernamen eingeben...">

      <label class="form-label">Passwort:</label>
      <input type="password" class="form-control" name="passwort" required="true" maxlength="255" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Passwort eingeben...">
      <small>mind. 8 Zeichen, Gross-Kleinschreibung, mind. eine Zahl und Sonderzeichen</small>
      <br>
      <button type="submit" name="button" value="submit" class="btn btn-info" id="button1">Login</button>
      <button type="reset" name="resetbtn" value="reset" class="btn btn-warning" id="button1">Clear</button>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      //Schauen ob die inputs leer sind oder nicht
      if (isset($_POST['benutzername']) && isset($_POST['passwort']) && strlen($_POST['benutzername']) <= 20 && strlen($_POST['passwort']) <= 255) {
        //Daten aus den inputs herausnehmen
        $benutzername = htmlspecialchars(trim($_POST['benutzername']));
        $passwort = htmlspecialchars(trim($_POST['passwort']));
      }
      //Überprüfung ob die Daten den Anforderungen Entsprechen
      if(!preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}/", $passwort)){
        //findet Passwort vom Benutzer aus der Datenbank
        $hashedPW = "SELECT Passwort from users where Benutzername = '".$benutzername."'";
        $result = mysqli_query($mysqli, $hashedPW);

        while ($row = mysqli_fetch_array($result)) { 
          //schaut ob eingegebenes passwort mit gehashtem Passwort aus Datenbank übereinstimmt.
          if(password_verify($passwort, $row['Passwort'])){
            //Sessions
            $_SESSION['bname'] = $benutzername;
            $_SESSION['loggedin'] = true;
            $_SESSION['limit1'] = 0;
            $_SESSION['limit2'] = 5;
            $_SESSION['num'] = 1;
            $_SESSION['counter'] = 0;

            header('Location: index.php');

            $uid = "SELECT uid from users where Benutzername = '".$benutzername."'";
            $result1 = mysqli_query($mysqli, $uid);
            while ($row = mysqli_fetch_array($result1)) {
              $uid = $row['uid']; 
            }
            //Sessions
            $_SESSION['bnameInt'] = $uid;

          } else if(!password_verify($password, $row['Passwort'])){
            echo "Der Benutzername oder das Passwort ist falsch.";
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