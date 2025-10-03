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
        
        <div class="movie-grid">
            <!-- Card 1 -->
            <div class="movie-card">
                <div class="movie-image">Capa</div>
                <h3>Título do Filme</h3>
                <p>Resumo curto sobre o filme ou gênero.</p>
                <button>Ver Review</button>
            </div>

            <!-- Card 2 -->
            <div class="movie-card">
                <div class="movie-image">Capa</div>
                <h3>Título do Filme</h3>
                <p>Descrição rápida do conteúdo.</p>
                <button>Ver Review</button>
            </div>

            <!-- Card 3 -->
            <div class="movie-card">
                <div class="movie-image">Capa</div>
                <h3>Título do Filme</h3>
                <p>Um breve resumo do que esperar.</p>
                <button>Ver Review</button>
            </div>
        </div>
    </main>

    <?php include 'rodape.php';?>
</body>
</html>