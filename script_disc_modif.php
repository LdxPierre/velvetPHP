<?php
$error = false;

//Récolte des champs et échapper les caractères spéciaux
$disc_id = $_POST['disc_id'];

if (isset($_POST['title']) && $_POST['title'] != "") {
    $title = htmlentities($_POST['title']);
} else {
    $error = true;
}
if (isset($_POST['artist']) && $_POST['artist'] != "") {
    $artist = htmlentities($_POST['artist']);
} else {
    $error = true;
}
if (isset($_POST['year']) && $_POST['year'] != "") {
    $year = htmlentities($_POST['year']);
} else {
    $error = true;
}
if (isset($_POST['genre']) && $_POST['genre'] != "") {
    $genre = htmlentities($_POST['genre']);
} else {
    $genre = null;
}
if (isset($_POST['label']) && $_POST['label'] != "") {
    $label = htmlentities($_POST['label']);
} else {
    $label = null;
}
if (isset($_POST['price']) && $_POST['price'] != "") {
    $price = htmlentities($_POST['price']);
} else {
    $error = true;
}

//Check format fichier si fichier présent
if ($_FILES['picture']['size'] > 0) {
    $ftype = array("image/jpeg", "image/jpg", "image/png");
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimetype = finfo_file($finfo, $_FILES["picture"]["tmp_name"]);
    finfo_close($finfo);
    if (in_array($mimetype, $ftype)) {
        $error = false;
    } else {
        $error = true;
        echo 'Format de fichier incorrect <br>';
        echo '<a href="discs.php">Retour vers la liste de disques.</a><br>';
        die ();
    }
}

//Si aucune erreur
if ($error == false) { 

    //Connexion db
    require "db.php";
    $db = ConnexionBase();

    //Si fichier présent
    if ($_FILES['picture']['size'] > 0) {

        //Suppression de l'ancienne img si elle existe
        try {
            $requete = $db -> prepare("SELECT disc_picture FROM disc WHERE disc_id=?");
            $requete->execute(array($disc_id));
            $disc = $requete->fetch(PDO::FETCH_OBJ);
            $requete->closeCursor();
        }
        catch (Exception $e) {
            var_dump($requete -> queryString);
            var_dump($requete -> errorInfo());
            echo 'Erreur :' . $requete -> errorInfo()[2] . '<br>';
            echo 'Fin du script (script_disc_modif.php)<br>';
            echo '<a href="discs.php">Retour vers la liste de disques.</a><br>';
            die ();
        }

        if (file_exists("IMG/jaquettes/" . $disc -> disc_picture)) {
            unlink("IMG/jaquettes/". $disc -> disc_picture);
        }

        //Ajout de la nouvelle img
        move_uploaded_file($_FILES["picture"]["tmp_name"],"IMG/jaquettes/". $title);

        //UPDATE disc_picture
        try {
            $requete = $db -> prepare("UPDATE disc SET disc_picture = :picture WHERE disc_id = :id");
            $requete -> bindValue(":picture", $title, PDO::PARAM_STR);
            $requete -> bindValue(":id", $disc_id, PDO::PARAM_STR);
            $requete -> execute();
            $requete -> closeCursor();
        }

        catch (Exception $e) {
            echo 'Erreur lors de l\'update \'disc_picture\'';
            var_dump($requete -> queryString);
            var_dump($requete -> errorInfo());
            echo 'Erreur :' . $requete -> errorInfo()[2] . '<br>';
            echo 'Fin du script (script_disc_modif.php)<br>';
            echo '<a href="discs.php">Retour vers la liste de disques.</a><br>';
            die ();
        }
    }

    try {
        //Conversion artist_name > artist_id
        $requete = $db -> prepare("SELECT artist_id FROM artist WHERE artist_name = ?");
        $requete -> execute(array($artist));
        $result = $requete -> fetch(PDO::FETCH_DEFAULT);
        $requete -> closeCursor();
        $artist = $result[0];

        //UPDATE
        $requete = $db -> prepare("UPDATE disc
            SET disc_title = :title, artist_id = :artist, disc_year = :year, disc_genre = :genre, disc_label = :label, disc_price = :price
            WHERE disc_id= :disc_id");
        $requete -> bindValue(":title", $title, PDO::PARAM_STR);
        $requete -> bindValue(":artist", $artist, PDO::PARAM_STR);
        $requete -> bindValue(":year", $year, PDO::PARAM_STR);
        $requete -> bindValue(":genre", $genre, PDO::PARAM_STR);
        $requete -> bindValue(":label", $label, PDO::PARAM_STR);
        $requete -> bindValue(":price", $price, PDO::PARAM_STR);
        $requete -> bindValue(":disc_id", $disc_id, PDO::PARAM_STR);
        $requete -> execute();
        $requete -> closeCursor();
    }

    catch (Exception $e) {
        echo 'Erreur lors de l\'update disc';
        var_dump($requete -> queryString);
        var_dump($requete -> errorInfo());
        echo 'Erreur :' . $requete -> errorInfo()[2] . '<br>';
        echo 'Fin du script (script_disc_modif.php)<br>';
        echo '<a href="discs.php">Retour vers la liste de disques.</a><br>';
        die ();
    }

    //Redirection
    header("location: disc_detail.php?id=" . $disc_id);

    exit;

} else {
    echo "Erreur dans les saisies";
    echo '<a href="discs.php">Retour vers la liste de disques.</a><br>';
    die ();
}
?>