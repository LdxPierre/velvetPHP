<?php
    require "db.php";
    $db = ConnexionBase();

    //Récupération du nom de la jaquette
    try {
        $query = $db->prepare("SELECT disc_picture FROM disc WHERE disc_id=?");
        $query->execute(array($_GET["id"]));
        $disc = $query->fetch(PDO::FETCH_OBJ);
        $query->closeCursor();
    }
    catch (Exception $e) {
        echo'ERREUR 1';
    }

    //Suppression de la jaquette
    unlink('IMG/jaquettes/'. $disc -> disc_picture);

    //Suppression dans la db
    try {
        $query = $db->prepare("DELETE FROM disc WHERE disc_id=?");
        $query->execute(array($_GET['id']));
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        $query->closeCursor();
    }
    catch (Exception $e) {
        echo 'ERREUR 2';
    }

    //redirection vers discs.php
    header("location: discs.php");
?>