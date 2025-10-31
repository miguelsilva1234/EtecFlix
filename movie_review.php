<?php
// movie_review.php
// Single-file movie review page with likes and comments (file-based storage)
// Save this file to your PHP server (e.g., XAMPP / LAMP) in a writable folder.

// Path to data file
$dataFile = __DIR__ . '/movie_data.json';

// Initialize default data if file doesn't exist
$defaultData = [
    'movie' => [
        'title' => 'Título do Filme',
        'year' => 2024,
        'director' => 'Diretor Exemplo',
        'synopsis' => 'Uma breve sinopse do filme: ação, emoção e reviravoltas.',
        'poster' => 'https://via.placeholder.com/300x450?text=Poster+do+Filme'
    ],
    'likes' => 0,
    'comments' => []
];

// Create data file if missing
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode($defaultData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Load data safely
function load_data($path) {
    $raw = @file_get_contents($path);
    if ($raw === false) return null;
    $data = json_decode($raw, true);
    return is_array($data) ? $data : null;
}

function save_data($path, $data) {
    // use file locking for safety
    $fp = fopen($path, 'c');
    if (!$fp) return false;
    flock($fp, LOCK_EX);
    ftruncate($fp, 0);
    fwrite($fp, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return true;
}

$data = load_data($dataFile);
if ($data === null) {
    $data = $defaultData;
    save_data($dataFile, $data);
}

// Handle AJAX actions: like / comment
$action = $_GET['action'] ?? '';
if ($action === 'like') {
    // Return JSON with updated like count
    header('Content-Type: application/json; charset=utf-8');
    // Increase likes safely
    $data = load_data($dataFile);
    if ($data === null) { http_response_code(500); echo json_encode(['error' => 'Erro ao ler dados']); exit; }
    $data['likes'] = ($data['likes'] ?? 0) + 1;
    if (!save_data($dataFile, $data)) { http_response_code(500); echo json_encode(['error' => 'Erro ao gravar dados']); exit; }
    echo json_encode(['likes' => $data['likes']]);
    exit;
}

if ($action === 'comment' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    $name = trim($_POST['name'] ?? 'Anônimo');
    $text = trim($_POST['comment'] ?? '');
    if ($text === '') { http_response_code(400); echo json_encode(['error' => 'Comentário vazio']); exit; }
    // Basic sanitization
    $name = mb_substr(strip_tags($name), 0, 100);
    $text = mb_substr(strip_tags($text), 0, 2000);

    $comment = [
        'name' => $name ?: 'Anônimo',
        'text' => $text,
        'date' => date('Y-m-d H:i:s')
    ];

    $data = load_data($dataFile);
    if ($data === null) { http_response_code(500); echo json_encode(['error' => 'Erro ao ler dados']); exit; }
    // prepend comment so newest appears first
    array_unshift($data['comments'], $comment);
    // Optionally limit stored comments to last 200
    if (count($data['comments']) > 200) $data['comments'] = array_slice($data['comments'], 0, 200);
    if (!save_data($dataFile, $data)) { http_response_code(500); echo json_encode(['error' => 'Erro ao gravar dados']); exit; }
    echo json_encode(['success' => true, 'comment' => $comment]);
    exit;
}

// For normal page display, proceed to HTML output
?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($data['movie']['title']); ?> — Review</title>
    <style>
        /* Reset simples */
        * { box-sizing: border-box; }
        body { font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; margin:0; background: linear-gradient(180deg,#0f1724 0%, #071428 100%); color: #e6eef8; padding: 24px; }
        .container { max-width:1000px; margin: 0 auto; }
        header { display:flex; align-items:center; gap:16px; margin-bottom:20px; }
        .logo { font-weight:700; font-size:20px; background: linear-gradient(90deg,#6ee7b7,#60a5fa); -webkit-background-clip:text; background-clip:text; color:transparent; }

        .card { display:flex; gap:24px; background: rgba(255,255,255,0.03); border-radius:12px; padding:20px; box-shadow: 0 6px 18px rgba(2,6,23,0.6); }
        .poster { min-width: 220px; border-radius:8px; overflow:hidden; }
        .poster img { display:block; width:100%; height:auto; }
        .meta { flex:1; }
        h1 { margin:0 0 8px 0; font-size:28px; }
        .sub { color: #a7b4c8; margin-bottom:12px; }
        .synopsis { margin-bottom:16px; line-height:1.5; color:#dce7f5; }

        .controls { display:flex; gap:12px; align-items:center; }
        .like-btn { display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:10px; cursor:pointer; user-select:none; background: rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.04); transition: transform .12s ease, background .12s ease; }
        .like-btn:active { transform: scale(.98); }
        .like-count { font-weight:700; }

        /* Comments */
        .comments { margin-top:18px; }
        .comment-form { margin-bottom:14px; display:flex; flex-direction:column; gap:8px; }
        input[type="text"], textarea { background: rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.04); color: #e6eef8; padding:10px; border-radius:8px; width:100%; }
        textarea { min-height:80px; resize:vertical; }
        .btn { padding:10px 14px; border-radius:8px; cursor:pointer; border:none; background: linear-gradient(90deg,#2563eb,#06b6d4); color:white; font-weight:600; }

        .comment { background: rgba(255,255,255,0.02); padding:12px; border-radius:10px; margin-bottom:8px; }
        .comment .who { font-weight:700; color:#fff; }
        .comment .when { color:#9fb0d4; font-size:12px; }
        .no-comments { color:#9fb0d4; }

        footer { margin-top:28px; color:#9fb0d4; font-size:13px; text-align:center; }

        /* responsive */
        @media (max-width:760px) {
            .card { flex-direction:column; }
            .poster { width:100%; max-width:320px; margin:0 auto; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">FilmReview</div>
            <div style="margin-left:auto; color:#9fb0d4">Página de review — Curtidas & Comentários</div>
        </header>

        <main>
            <section class="card">
                <div class="poster">
                    <img src="<?php echo htmlspecialchars($data['movie']['poster']); ?>" alt="Poster">
                </div>
                <div class="meta">
                    <h1><?php echo htmlspecialchars($data['movie']['title']); ?> (<?php echo htmlspecialchars($data['movie']['year']); ?>)</h1>
                    <div class="sub">Direção: <?php echo htmlspecialchars($data['movie']['director']); ?></div>
                    <div class="synopsis"><?php echo nl2br(htmlspecialchars($data['movie']['synopsis'])); ?></div>

                    <div class="controls">
                        <div id="likeBtn" class="like-btn" role="button" aria-pressed="false">
                            <svg id="heartIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                            <div class="like-count" id="likeCount"><?php echo intval($data['likes']); ?></div>
                        </div>

                        <div style="color:#9fb0d4">Clique em "Curtir" se você aprovou o review</div>
                    </div>

                    <div class="comments">
                        <form id="commentForm" class="comment-form">
                            <input type="text" name="name" id="name" placeholder="Seu nome (opcional)">
                            <textarea name="comment" id="comment" placeholder="Escreva seu comentário..."></textarea>
                            <div style="display:flex; gap:8px;">
                                <button class="btn" type="submit">Enviar comentário</button>
                                <button type="button" id="clearBtn" class="btn" style="background:transparent; border:1px solid rgba(255,255,255,0.06); color:#cfe6ff;">Limpar</button>
                            </div>
                        </form>

                        <div id="commentsList">
                            <?php if (empty($data['comments'])): ?>
                                <div class="no-comments">Seja o primeiro a comentar.</div>
                            <?php else: ?>
                                <?php foreach ($data['comments'] as $c): ?>
                                    <div class="comment">
                                        <div class="who"><?php echo htmlspecialchars($c['name']); ?> <span class="when">— <?php echo htmlspecialchars($c['date']); ?></span></div>
                                        <div class="what"><?php echo nl2br(htmlspecialchars($c['text'])); ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </section>
        </main>

        <footer>
            Arquivo de dados: <code><?php echo htmlspecialchars(basename($dataFile)); ?></code> — Certifique-se que a pasta é gravável.
        </footer>
    </div>

<script>
// Simple JS to handle like and comment AJAX
const likeBtn = document.getElementById('likeBtn');
const likeCount = document.getElementById('likeCount');
likeBtn.addEventListener('click', async () => {
    likeBtn.setAttribute('aria-pressed', 'true');
    try {
        const res = await fetch('?action=like', { method: 'POST' });
        if (!res.ok) throw new Error('Erro');
        const data = await res.json();
        likeCount.textContent = data.likes;
        // quick pulse animation
        likeBtn.animate([
            { transform: 'scale(1)' },
            { transform: 'scale(1.06)' },
            { transform: 'scale(1)' }
        ], { duration: 220 });
    } catch (err) {
        console.error(err);
        alert('Não foi possível registrar a curtida.');
    } finally {
        likeBtn.setAttribute('aria-pressed', 'false');
    }
});

// Comments
const commentForm = document.getElementById('commentForm');
const commentsList = document.getElementById('commentsList');
const clearBtn = document.getElementById('clearBtn');
commentForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const name = document.getElementById('name').value.trim();
    const comment = document.getElementById('comment').value.trim();
    if (!comment) { alert('Escreva um comentário antes de enviar.'); return; }
    try {
        const form = new FormData();
        form.append('name', name);
        form.append('comment', comment);
        const res = await fetch('?action=comment', { method: 'POST', body: form });
        if (!res.ok) {
            const err = await res.json().catch(()=>({error:'Erro'}));
            throw new Error(err.error || 'Erro ao enviar');
        }
        const data = await res.json();
        // Prepend new comment visually
        const c = data.comment;
        const div = document.createElement('div');
        div.className = 'comment';
        div.innerHTML = `<div class="who">${escapeHtml(c.name)} <span class="when">— ${escapeHtml(c.date)}</span></div><div class="what">${nl2br(escapeHtml(c.text))}</div>`;
        // If "Seja o primeiro..." message exists, remove it
        const first = commentsList.querySelector('.no-comments');
        if (first) first.remove();
        commentsList.prepend(div);
        // clear textarea
        document.getElementById('comment').value = '';
    } catch (err) {
        console.error(err);
        alert('Não foi possível enviar o comentário.');
    }
});
clearBtn.addEventListener('click', ()=>{
    document.getElementById('name').value = '';
    document.getElementById('comment').value = '';
});

function escapeHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function nl2br(s) { return s.replace(/\n/g,'<br>'); }
</script>
</body>
</html>
