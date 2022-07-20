<?php
    include "db.php";
    $db = connexionBase();
    $requete = $db->query("SELECT artist_name FROM artist");
    $tableau = $requete->fetchAll(PDO::FETCH_OBJ);
    $requete->closeCursor();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un vinyle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
<div class="container">
    
    <h1>Ajouter un vinyle</h1>

    <form action="script_disc_ajout.php" method="POST" enctype="multipart/form-data">
        <label class="form-label mt-2" for="title">Title</label>
        <input class="form-control" type="text" name='title' id="title" placeholder="Enter title" required>
        <label class="form-label mt-2" for="artist">Artist</label>
        <select class="form-select" type="text" name='artist' id="artist" required>
            <option selected value="">Select artist</option>
            <?php foreach ($tableau as $artist): ?>
                <option value="<?= $artist -> artist_name ?>"><?= $artist -> artist_name ?></option>
            <?php endforeach; ?>
        </select>
        <label class="form-label mt-2" for="year">Year</label>
        <input class="form-control" type="number" name='year' id="year" placeholder="Enter year" required>
        <label class="form-label mt-2" for="genre">Genre</label>
        <input class="form-control" type="text" name="genre" id="genre" placeholder="Enter genre (Rock, Pop, Prog ...)" >
        <label class="form-label mt-2" for="label">Label</label>
        <input class="form-control" type="text" name='label' id="label" placeholder="Enter label (EMI, Warner, PolyGram, Univers sale ...)" >
        <label class="form-label mt-2" for="price">Price</label>
        <input class="form-control" type="number" step=".01" name='price' id="price" required>
        <label class="form-label mt-2" for="picture">Picture</label>
        <input class="form-control" type="file" id="picture" name="picture" required>

        <input class="btn btn-primary mt-2" type="submit" value="Ajouter">
        <input class="btn btn-primary mt-2" type="button" onclick="document.location='discs.php'" value="Retour">
    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

</body>
</html>