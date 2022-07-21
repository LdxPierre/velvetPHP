<?php
    include "db.php";
    $db = connexionBase();
    $requete = $db->query("SELECT * FROM disc LEFT JOIN artist ON disc.artist_id = artist.artist_id ORDER BY disc_title");
    $tableau = $requete->fetchAll(PDO::FETCH_OBJ);
    $requete->closeCursor();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velvet Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="assets/CSS/stylesheet.css" rel="stylesheet">
</head>
<body>
<div class="container">

    <div class="d-flex justify-content-between mt-2">
        <h1 class="my-auto">Liste des disques (<?= count($tableau) ?>)</h1>
                <a class="my-auto btn btn-primary disctext" href='disc_new.php'>Ajouter</a>
    </div>

    <div class="d-flex flex-wrap mt-2">
        <?php foreach ($tableau as $disc): ?>
            <div class="d-flex col-md-6 my-1">
                <img class="col-5 img-fluid" src="IMG/jaquettes/<?= $disc -> disc_picture ?>" alt="<?= $disc -> disc_title ?>" title="<?= $disc -> disc_title ?>">
                <div class="d-flex flex-column flex-grow-1 mx-2 justify-content-between">
                    <div>
                        <p class="m-0 fw-bold"><?= $disc -> disc_title ?></p>
                        <p class="m-0 fw-bold disctext"><?= $disc -> artist_name ?></p>
                        <p class="m-0 disctext"><b>Label : </b><?= $disc -> disc_label ?></p>
                        <p class="m-0 disctext"><b>Year : </b><?= $disc -> disc_year ?></p>
                        <p class="m-0 disctext"><b>Genre : </b><?= $disc -> disc_genre ?></p>
                    </div>
                    <div>
                        <a class="mb-2 btn btn-primary disctext" href="disc_detail.php?id=<?= $disc -> disc_id ?>">Détails</a>
                    </div>    
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</html>