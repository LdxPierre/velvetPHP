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
        var_dump($requete -> queryString);
        var_dump($requete -> errorInfo());
        echo 'Erreur :' . $requete -> errorInfo()[2] . '<br>';
        echo 'Fin du script (script_disc_modif.php)<br>';
        echo '<a href="discs.php">Retour vers la liste de disques.</a><br>';
        die ();
    }

    //Suppression de la jaquette
    if (file_exists("IMG/jaquettes/" . $disc -> disc_picture)) {
        unlink("IMG/jaquettes/". $disc -> disc_picture);
    }

    //Suppression dans la db
    try {
        $query = $db->prepare("DELETE FROM disc WHERE disc_id=?");
        $query->execute(array($_GET['id']));
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        $query->closeCursor();
    }
    catch (Exception $e) {
        var_dump($requete -> queryString);
        var_dump($requete -> errorInfo());
        echo 'Erreur :' . $requete -> errorInfo()[2] . '<br>';
        echo 'Fin du script (script_disc_modif.php)<br>';
        echo '<a href="discs.php">Retour vers la liste de disques.</a><br>';
        die ();
    }

    //redirection vers discs.php
    header("location: discs.php");
?>