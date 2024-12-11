<?php

$id = isset($_GET['id']) ? $_GET['id'] : 1;
$apiUrl = "https://rickandmortyapi.com/api/character/$id";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$character = json_decode($response, true);


$suggestionIds = array_rand(range(1, 826), 5); // 826 es el total de personajes
$suggestions = [];

foreach ($suggestionIds as $suggestionId) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://rickandmortyapi.com/api/character/$suggestionId");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $suggestions[] = json_decode($response, true);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $character['name']; ?> - Rick and Morty</title>

    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <a href="index.php" class="d-grid gap-2 d-md-flex justify-content-md-end">Regresar</a>
        <h1><?= $character['name']; ?></h1>
        <div class="row">
            <div class="col-md-4">

                <img src="<?= $character['image']; ?>" class="img-fluid" alt="<?= $character['name']; ?>">
            </div>
            <div class="col-md-8">
                <p><strong>Estado:</strong> <?= $character['status']; ?></p>
                <p><strong>Especie:</strong> <?= $character['species']; ?></p>
                <p><strong>Genero:</strong> <?= $character['gender']; ?></p>
                <p><strong>Origen:</strong> <?= $character['origin']['name']; ?></p>
            </div>
        </div>

        <h2 class="mt-5">Sugerencias</h2>
        <div class="row">
            <?php foreach ($suggestions as $suggestion): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= $suggestion['image']; ?>" class="card-img-top" alt="<?= $suggestion['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $suggestion['name']; ?></h5>
                            <a href="detail.php?id=<?= $suggestion['id']; ?>" class="btn btn-secondary">Ver</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>