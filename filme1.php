<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/filmes1.css">
</head>
<body>
  <?php include __DIR__ . '/includes/header.php'; ?>
  <main class="avaliacao-container">
    <div class="filme-card">
      <img src="img/capa_filme1.jpeg" alt="Capa do Filme" class="filme-capa">
      <div class="filme-info">
        <h2>Homem-Aranha</h2>
        <p class="sinopse">
        No primeiro filme da trilogia, Peter Parker é um jovem tímido que ganha poderes após ser picado por uma aranha radioativa. 
        Enquanto tenta entender sua nova responsabilidade como herói, ele enfrenta o perigoso Duende Verde. 
        Com uma mistura de ação e emoção, o filme mostra a origem do herói e a famosa lição: “Com grandes poderes vêm grandes responsabilidades.”
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
  <?php include __DIR__ . '/includes/rodape.php'; ?>

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