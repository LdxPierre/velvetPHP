<?php
    require "db.php";
    $db = connexionBase();
    $requete = $db->prepare("SELECT * FROM disc JOIN artist ON artist.artist_id = disc.artist_id WHERE disc_id=?");
    $requete->execute(array($_GET["id"]));
    $disc = $requete->fetch(PDO::FETCH_OBJ);
    $requete->closeCursor();
    $requete = $db->prepare("SELECT DISTINCT artist_name FROM artist LEFT JOIN disc ON disc.artist_id = artist.artist_id WHERE disc_id <>? OR disc_id IS NULL");
    $requete->execute(array($_GET["id"]));
    $artist = $requete->fetchAll(PDO::FETCH_OBJ);
    $requete->closeCursor();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un vinyle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="assets/CSS/stylesheet.css" rel="stylesheet">
</head>
<body>
<div class="container">

    <h1>Modifier un vinyle</h1>

    <div class="disctext">
        <form action="script_disc_modif.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="disc_id" value="<?= $disc -> disc_id ?>" readonly> 
            <label class="mt-2" for="title">Title</label>
            <input class="form-control" type="text" name='title' id="title" value="<?= $disc -> disc_title ?>" required>
            <label class="mt-2" for="artist">Artist</label>
            <select class="form-select" type="text" name='artist' id="artist" value="<?= $disc -> artist_name ?>" required>
                <option value="<?= $disc -> artist_name?>" selected><?= $disc -> artist_name?></option>
                <?php foreach ($artist as $artist):?>
                    <option value="<?= $artist -> artist_name ?>"><?= $artist -> artist_name?></option>
                <?php endforeach;?>
            </select>
            <label class="mt-2" for="year">Year</label>
            <input class="form-control" type="number" name='year' id="year" value="<?= $disc -> disc_year ?>"required>
            <label class="mt-2" class="mt-2" for="genre">Genre</label>
            <input class="form-control" type="text" name='genre' id="genre" value="<?= $disc -> disc_genre ?>">
            <label class="mt-2" for="label">Label</label>
            <input class="form-control" type="text" name='label' id="label" value="<?= $disc -> disc_label ?>">
            <label class="mt-2" for="price">Price</label>
            <input class="form-control" type="number" step=".01" name='price' id="price" value="<?= $disc -> disc_price ?>" required>
            <label class="mt-2" for="picture">Picture</label>
            <input class="form-control" type="file" name="picture" id="picture">
            <img class="my-2" src="IMG/jaquettes/<?= $disc -> disc_picture ?>">

            <input class="btn btn-primary" type="button" value="Retour" onclick="document.location='disc_detail.php?id=<?= $disc -> disc_id ?>'">
            <input class="btn btn-primary" type="submit" value="Modifier">
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>    
</body>
</html>