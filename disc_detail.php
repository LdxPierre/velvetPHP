<?php
    require "db.php";
    $db = connexionBase();
    $requete = $db->prepare("SELECT * FROM disc JOIN artist ON artist.artist_id = disc.artist_id WHERE disc_id=?");
    $requete->execute(array($_GET["id"]));
    $tableau = $requete->fetch(PDO::FETCH_OBJ);
    $requete->closeCursor();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tableau -> disc_title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="assets/CSS/stylesheet.css" rel="stylesheet">
</head>
<body>
<div class="container">

    <h2>Details</h2>

    <div class="disctext">
        <div class="row">
            <div class="col-sm">
                <label class="mt-2" for="title">Title</label>
                <input class="form-control" type="text" name='title' id="title" value="<?= $tableau -> disc_title ?>" readonly disabled>
            </div>
            <div class="col-sm">
                <label class="mt-2" for="artist">Artist</label>
                <input class="form-control" type="text" name='artist' id="artist" value="<?= $tableau -> artist_name ?>" readonly disabled>
            </div>
        </div>

        <div class="row">
            <div class="col-sm">
                <label class="mt-2" for="year">Year</label>
                <input class="form-control" type="number" name='year' id="year" value="<?= $tableau -> disc_year ?>" readonly disabled>
            </div>
            <div class="col">
                <label class="mt-2" for="genre">Genre</label>
                <input class="form-control" type="text" name='genre' id="genre" value="<?= $tableau -> disc_genre ?>" readonly disabled>
            </div>
        </div>

        <div class="row">
            <div class="col-sm">
                <label class="mt-2" for="label">Label</label>
                <input class="form-control" type="text" name='label' id="label" value="<?= $tableau -> disc_label ?>" readonly disabled>
            </div>
            <div class="col-sm">
                <label class="mt-2" for="price">Price</label>
                <input class="form-control" type="number" name='price' id="price" value="<?= $tableau -> disc_price ?>" readonly disabled>
            </div>
        </div>

        <div class="row mb-2">
            <label class="mt-2" for="picture">Picture</label>
            <img class="col-sm-6" src="IMG/jaquettes/<?= $tableau -> disc_picture ?>" id="picutre">
        </div>

        <a class="btn btn-primary" href="discs.php">Retour</a>
        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal">Supprimer</a> <!-- Affiche une box de confirmation -->
        <a class="btn btn-primary" href="disc_form.php?id=<?= $tableau -> disc_id ?>">Modifer</a>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Supprimer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Confirmer la suppression de '<?= $tableau -> disc_title ?>' ?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="button" class="btn btn-danger" onclick="document.location='script_disc_delete.php?id=<?= $tableau -> disc_id ?>'">Confirmer</button>
        </div>
        </div>
    </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>    
</body>
</html>