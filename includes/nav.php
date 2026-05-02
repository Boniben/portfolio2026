<?php $page_active = $_GET['page'] ?? 'home'; ?>
<nav class="navbar">
    <div class="nav-brand">
        <a href="/portefolio/"><?= STUDENT_NAME ?></a>
        <span class="nav-badge"><?= FORMATION ?> <?= OPTION ?></span>
    </div>
    <button class="nav-toggle" id="navToggle" aria-label="Menu">&#9776;</button>
    <ul class="nav-links" id="navLinks">
        <li><a href="/portefolio/?page=home"       class="<?= $page_active === 'home'        ? 'active' : '' ?>">Accueil</a></li>
        <li><a href="/portefolio/?page=apropos"    class="<?= $page_active === 'apropos'      ? 'active' : '' ?>">À propos</a></li>
        <li><a href="/portefolio/?page=competences" class="<?= $page_active === 'competences'  ? 'active' : '' ?>">Compétences</a></li>
        <li><a href="/portefolio/?page=projets"    class="<?= $page_active === 'projets'      ? 'active' : '' ?>">Projets</a></li>
        <li><a href="/portefolio/?page=documents"  class="<?= $page_active === 'documents'    ? 'active' : '' ?>">Documents</a></li>
        <li><a href="/portefolio/?page=contact"    class="<?= $page_active === 'contact'      ? 'active' : '' ?>">Contact</a></li>
    </ul>
</nav>
