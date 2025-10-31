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
      <img src="img/capa_filme2.jpeg" alt="Capa do Filme" class="filme-capa">
      <div class="filme-info">
        <h2>Homem-Aranha 2</h2>
        <p class="sinopse">
        Em Homem-Aranha 2, Peter Parker enfrenta um dos maiores desafios de sua vida: equilibrar o papel de herói com sua vida pessoal. 
        Enquanto tenta manter seus estudos, amizades e o amor por Mary Jane, ele precisa enfrentar o brilhante e trágico Dr. Octopus. 
        O filme aprofunda o lado humano do herói e é considerado por muitos o melhor da trilogia.
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