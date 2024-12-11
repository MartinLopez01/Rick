<?php

$apiUrl = "https://rickandmortyapi.com/api/character";
$page = isset($_GET['page']) ? $_GET['page'] : 1;


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl . "?page=" . $page);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);


$data = json_decode($response, true);
$characters = $data['results'] ?? [];
$totalPages = $data['info']['pages'] ?? 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rick Y Morty</title>
    <link rel="stylesheet" href="css/estilos.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h1 class="text-center mb-4">Rick and Morty</h1>
        <div class="row">
            <?php foreach ($characters as $character): ?>
                <div class="col-12 mb-3">
                    <div class="card character-card">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img src="<?= $character['image']; ?>" class="img-fluid rounded-start character-image" alt="<?= $character['name']; ?>">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h5 class="card-title mb-1"><?= $character['name']; ?></h5>
                                    <p class="mb-1 text-muted">
                                        <?= $character['status'] === 'Alive' ? '🟢' : ($character['status'] === 'Dead' ? '🔴' : '⚪'); ?>
                                        <?= $character['status']; ?> - <?= $character['species']; ?>
                                    </p>
                                    <p class="mb-1"><strong>Ultima ubicacion conocida:</strong> <?= $character['location']['name']; ?></p>
                                    <p class="mb-1"><strong>Visto por primera vez en:</strong> <?= $character['origin']['name']; ?></p>
                                    <a href="detail.php?id=<?= $character['id']; ?>" class="btn btn-outline-info mt-2">Ver Mas</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <nav aria-label="Paginacion">
            <ul class="pagination justify-content-center">

                <li class="page-item <?= $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?= max(1, $page - 1); ?>" aria-label="Atras">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($totalPages, $page + 2);
                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $page >= $totalPages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?= min($totalPages, $page + 1); ?>" aria-label="Siguiente">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</body>

</html>