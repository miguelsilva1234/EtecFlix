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
                <div class="movie-image"></div>
                <h3>Título do Filme</h3>
                <p>Resumo curto sobre o filme ou gênero.</p>
                <a href="filme1.php" type="button "class="active">Início</a>
            </div>

            <!-- Card 2 -->
            <div class="movie-card">
                <div class="movie-image"></div>
                <h3>Título do Filme</h3>
                <p>Resumo curto sobre o filme ou gênero.</p>
                <a href="filme1.php" type="button "class="active">Início</a>
            </div>

            <!-- Card 3 -->
            <div class="movie-card">
                <div class="movie-image"></div>
                <h3>Título do Filme</h3>
                <p>Resumo curto sobre o filme ou gênero.</p>
                <a href="filme1.php" type="button "class="active">Início</a>
            </div>
        </div>
    </main>

    <?php include 'rodape.php';?>
</body>
</html>