<?php
$blocs   = require_once __DIR__ . '/../data/competences.php';
$projets = require_once __DIR__ . '/../data/projets.php';

// Index projets par id
$projets_index = [];
foreach ($projets as $p) {
    $projets_index[$p['id']] = $p;
}
?>

<section class="page-section">
    <h2 class="page-title">Compétences E5</h2>
    <p class="page-intro">Référentiel de compétences de l'épreuve E5 — une compétence validée par bloc est indiquée par un lien vers les preuves correspondantes.</p>

    <?php foreach ($blocs as $bloc_id => $bloc): ?>
    <div class="bloc">
        <h3 class="bloc-title">
            <span class="bloc-ref"><?= htmlspecialchars($bloc_id) ?></span>
            <?= htmlspecialchars($bloc['label']) ?>
        </h3>
        <div class="competences-grid">
            <?php foreach ($bloc['competences'] as $comp): ?>
            <div class="card competence-card <?= !empty($comp['projets']) ? 'validee' : '' ?>">
                <div class="comp-header">
                    <span class="comp-ref"><?= htmlspecialchars($comp['ref']) ?></span>
                    <span class="comp-label"><?= htmlspecialchars($comp['label']) ?></span>
                </div>

                <?php if (!empty($comp['projets'])): ?>
                <div class="comp-projets">
                    <?php foreach ($comp['projets'] as $pid):
                        if (!isset($projets_index[$pid])) continue;
                        $p = $projets_index[$pid];
                    ?>
                    <a href="/portefolio/?page=documents#<?= htmlspecialchars($pid) ?>" class="comp-projet-link">
                        &#128196; <?= htmlspecialchars($p['titre']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</section>
