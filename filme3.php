<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="filmes1.css">
</head>
<body>
    <?php include 'header.php';?>
  <main class="avaliacao-container">
    <div class="filme-card">
      <img src="img/filme1.jpg" alt="Capa do Filme" class="filme-capa">
      <div class="filme-info">
        <h2>Homem-Aranha 3</h2>
        <p class="sinopse">
        No encerramento da trilogia, Peter Parker precisa lidar com o simbionte que o transforma no Homem-Aranha negro, 
        enquanto enfrenta o vingativo Homem-Areia e o novo Duende. 
        O filme mostra como o poder e o orgulho podem corromper até o herói mais puro, encerrando a jornada de Tobey Maguire com emoção e redenção.
        </p>

        <div class="avaliacao-estrelas">
          <span class="estrela" data-value="1">★</span>
          <span class="estrela" data-value="2">★</span>
          <span class="estrela" data-value="3">★</span>
          <span class="estrela" data-value="4">★</span>
          <span class="estrela" data-value="5">★</span>
        </div>

        <textarea placeholder="Deixe sua opinião sobre o filme..."></textarea>
        <button class="btn-enviar">Enviar Avaliação</button>
      </div>
    </div>
  </main>
    <?php include 'rodape.php';?>

    <script>
        // Sistema simples de estrelas
        const estrelas = document.querySelectorAll('.estrela');
        estrelas.forEach(estrela => {
            estrela.addEventListener('click', () => {
                estrelas.forEach(e => e.classList.remove('ativo'));
                estrela.classList.add('ativo');
                estrela.previousElementSibling?.classList.add('ativo');
                let prev = estrela.previousElementSibling;
                while (prev) {
                    prev.classList.add('ativo');
                    prev = prev.previousElementSibling;
                }
            });
        });
    </script>
</body>
</html>