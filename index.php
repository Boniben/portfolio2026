<?php
require_once 'config.php';

$pages_autorisees = ['home', 'apropos', 'competences', 'projets', 'documents', 'contact', 'code'];
$page = $_GET['page'] ?? 'home';

if (!in_array($page, $pages_autorisees)) {
    $page = 'home';
}

require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main class="main-content">
    <?php require_once "pages/{$page}.php"; ?>
</main>

<?php require_once 'includes/footer.php'; ?>
