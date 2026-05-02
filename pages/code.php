<?php
$projets   = require_once __DIR__ . '/../data/projets.php';
$projet_id = $_GET['projet'] ?? '';
$fichier   = $_GET['fichier'] ?? '';

// Validation
$projet_ids = array_column($projets, 'id');
if (!in_array($projet_id, $projet_ids) || empty($fichier)) {
    header('Location: /portefolio/?page=documents');
    exit;
}

// Sécurité : nom de fichier uniquement, pas de traversal
$fichier = basename($fichier);
$chemin  = __DIR__ . '/../documents/' . $projet_id . '/' . $fichier;
$ext     = strtolower(pathinfo($fichier, PATHINFO_EXTENSION));

$extensions_code = ['java', 'php', 'js', 'ts', 'html', 'css', 'xml', 'yml', 'yaml', 'json', 'properties', 'sql'];

if (!file_exists($chemin) || !in_array($ext, $extensions_code)) {
    header('Location: /portefolio/?page=documents');
    exit;
}

$contenu = htmlspecialchars(file_get_contents($chemin));

// Retrouver le titre du projet
$titre_projet = '';
foreach ($projets as $p) {
    if ($p['id'] === $projet_id) { $titre_projet = $p['titre']; break; }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($fichier) ?> — <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/portefolio/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <style>
        .code-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:1.5rem; }
        .code-header h2 { font-size:1.2rem; color:var(--primary); margin:0; }
        .code-breadcrumb { font-size:0.85rem; color:var(--text-muted); margin-bottom:0.5rem; }
        .code-breadcrumb a { color:var(--accent); }
        pre { margin:0; border-radius:var(--radius); font-size:0.85rem; }
        .hljs { border-radius:var(--radius); padding:1.5rem; }
        .code-wrap { background:var(--bg-card); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow); overflow:auto; }
    </style>
</head>
<body>
<?php require_once __DIR__ . '/../includes/nav.php'; ?>
<main class="main-content">
    <p class="code-breadcrumb">
        <a href="/portefolio/?page=documents#<?= htmlspecialchars($projet_id) ?>">← Documents</a>
        &nbsp;/&nbsp; <?= htmlspecialchars($titre_projet) ?>
        &nbsp;/&nbsp; <?= htmlspecialchars($fichier) ?>
    </p>
    <div class="code-header">
        <h2><?= htmlspecialchars($fichier) ?></h2>
        <a href="/portefolio/documents/<?= htmlspecialchars($projet_id) ?>/<?= rawurlencode($fichier) ?>" download class="btn btn-secondary btn-small">Télécharger</a>
    </div>
    <div class="code-wrap">
        <pre><code class="language-<?= $ext ?>"><?= $contenu ?></code></pre>
    </div>
</main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
<script>hljs.highlightAll();</script>
</body>
</html>
