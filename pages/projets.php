<?php $projets = require_once __DIR__ . '/../data/projets.php'; ?>

<section class="page-section">
    <h2 class="page-title">Projets & Situations</h2>
    <p class="page-intro">Situations professionnelles présentées lors de l'épreuve E5.</p>

    <div class="projets-grid">
        <?php foreach ($projets as $projet):
            $dossier = __DIR__ . '/../documents/' . $projet['id'] . '/';
            $nb_docs = 0;
            if (is_dir($dossier)) {
                $fichiers = array_filter(scandir($dossier), fn($f) => !in_array($f, ['.', '..']));
                $nb_docs = count($fichiers);
            }
        ?>
        <div class="card projet-card">
            <div class="projet-header">
                <h3><?= htmlspecialchars($projet['titre']) ?></h3>
                <span class="badge"><?= htmlspecialchars($projet['contexte']) ?></span>
            </div>
            <p class="projet-desc"><?= htmlspecialchars($projet['description']) ?></p>
            <div class="projet-tech">
                <?php foreach ($projet['technologies'] as $tech): ?>
                    <span class="tag"><?= htmlspecialchars($tech) ?></span>
                <?php endforeach; ?>
            </div>

            <?php if (!empty($projet['preuves'])): ?>
            <div class="preuves-attendues">
                <p class="preuves-label">Preuves attendues :</p>
                <ul>
                    <?php foreach ($projet['preuves'] as $preuve): ?>
                    <li><?= htmlspecialchars($preuve) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="projet-footer">
                <?php if (!empty($projet['url'])): ?>
                <a href="<?= htmlspecialchars($projet['url']) ?>" target="_blank" class="btn btn-primary btn-small">Accéder au projet</a>
                <?php endif; ?>
                <?php if (!empty($projet['github'])): ?>
                <a href="<?= htmlspecialchars($projet['github']) ?>" target="_blank" class="btn btn-outline btn-small">&#128279; GitHub</a>
                <?php endif; ?>
                <a href="/portefolio/?page=documents#<?= htmlspecialchars($projet['id']) ?>" class="btn btn-secondary btn-small">
                    Preuves
                    <?php if ($nb_docs > 0): ?>
                        <span class="doc-count"><?= $nb_docs ?></span>
                    <?php else: ?>
                        <span class="doc-count empty">0</span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
