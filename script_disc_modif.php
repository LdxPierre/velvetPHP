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

//Si aucune erreur
if ($error == false) { 

    //Connexion db
    require "db.php";
    $db = ConnexionBase();

    //Si fichier présent
    if (sizeof($_FILES) > 0) {
        //Suppression de l'ancienne img si elle existe
        $requete = $db -> prepare("SELECT disc_picture FROM disc WHERE disc_id=?");
        $requete->execute(array($disc_id));
        $disc = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        if (file_exists("IMG/jaquettes/" . $disc -> disc_picture)) {
            unlink("IMG/jaquettes/". $disc -> disc_picture);
        }
        //Ajout de la nouvelle img
        move_uploaded_file($_FILES["picture"]["tmp_name"],"IMG/jaquettes/". $title);
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
            SET disc_title = :title, artist_id = :artist, disc_year = :year, disc_genre = :genre, disc_label = :label, disc_price = :price, disc_picture = :picture
            WHERE disc_id= :disc_id");
        $requete -> bindValue(":title", $title, PDO::PARAM_STR);
        $requete -> bindValue(":artist", $artist, PDO::PARAM_STR);
        $requete -> bindValue(":year", $year, PDO::PARAM_STR);
        $requete -> bindValue(":genre", $genre, PDO::PARAM_STR);
        $requete -> bindValue(":label", $label, PDO::PARAM_STR);
        $requete -> bindValue(":price", $price, PDO::PARAM_STR);
        $requete -> bindValue(":picture", $title, PDO::PARAM_STR);
        $requete -> bindValue(":disc_id", $disc_id, PDO::PARAM_STR);
        $requete -> execute();
        $requete -> closeCursor();
    }

    catch (Exception $e) {
        var_dump($requete -> queryString);
        var_dump($requete -> errorInfo());
        echo "Erreur : ".$requete -> errorInfo()[2]."<br>";
        die("Fin du script (script_disc_ajout.php)");
    }

    //Redirection
    header("location: disc_detail.php?id=" . $disc_id);

    exit;

} else {
    echo "ERREUR AVANT L'UPDATE";
}



?>