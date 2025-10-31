<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="painel.css">
</head>
<body>
    <?php include 'header.php';?>

    <main class="main-content">
        <h2>Filmes em Destaque</h2>
        <hr>
        <div class="movie-grid">
            <!-- Card 1 -->
            <div class="movie-card">
                <div class="movie-image">
                    <img src="img/aranha 1.jpeg" alt="Homem-Aranha">
                </div>
                <h3>Homem-Aranha</h3>
                <a href="filmes2.php" class="active">Avaliar</a>
            </div>

            <!-- Card 2 -->
            <div class="movie-card">
                <div class="movie-image">
                    <img src="img/aranha 2.jpeg" alt="Homem-Aranha 2">
                </div>
                <h3>Homem-Aranha 2</h3>
                <a href="filmes2.php" class="active">Avaliar</a>
            </div>


            <!-- Card 3 -->
            <div class="movie-card">
                <div class="movie-image">
                    <img src="img/filme1.jpg" alt="Homem-Aranha 3">
                </div>
                <h3>Homem-Aranha 3</h3>
                <a href="filmes2.php" class="active">Avaliar</a>
            </div>
        </div>
    </main>

    <?php include 'rodape.php';?>
</body>
</html>