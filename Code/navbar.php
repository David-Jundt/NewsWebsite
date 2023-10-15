<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
</head>
<body>

    <ul class="nav nav-tabs">
        <li>
            <a class="nav-link" href="index.php">Homepage</a>
        </li>
        <li>
            <a class="nav-link" href="login.php">Login</a>
        </li>
        <li>
            <a class="nav-link" href="archiv.php">Archiv</a>
        </li>
        <li>
            <a class="nav-link" href="erstellenBenutzer.php">Registrierung</a>
        </li>

        <?php
        //Es werden keine Errors angezeigt
        error_reporting(0);
        //schaut ob benutzer angemeldet ist oder nicht
        if ($_SESSION['loggedin']) {
        ?>
            <li>
                <a class="nav-link" href="erstellenNews.php">News Erstellen</a>
            </li>
            <li>
                <a class="nav-link" href="erstellenKategorie.php">Kategorie Erstellen</a>
            </li>
            <li>
                <a class="nav-link" href="bearbeitenLoeschen.php">News Bearbeiten und Löschen</a>
            </li>
            <li>
                <a class="nav-link" href="passwortAendern.php">Passwort Ändern</a>
            </li>
            <li>
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        <?php
        }
        ?>
    </ul>

</body>
</html>