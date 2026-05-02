<?php $projets = require_once __DIR__ . '/../data/projets.php'; ?>

<section class="page-section">
    <h2 class="page-title">Documents de preuve</h2>
    <p class="page-intro">Preuves classées par situation, consultables et téléchargeables par le jury.</p>

    <?php foreach ($projets as $projet):
        $dossier  = __DIR__ . '/../documents/' . $projet['id'] . '/';
        $url_base = '/portefolio/documents/' . $projet['id'] . '/';
        $fichiers = [];
        if (is_dir($dossier)) {
            $fichiers = array_values(array_filter(scandir($dossier), fn($f) => !in_array($f, ['.', '..'])));
        }
    ?>
    <div class="doc-category" id="<?= htmlspecialchars($projet['id']) ?>">
        <div class="doc-cat-header">
            <div>
                <h3 class="doc-cat-title"><?= htmlspecialchars($projet['titre']) ?></h3>
                <p class="doc-cat-desc"><?= htmlspecialchars($projet['contexte']) ?></p>
            </div>
            <?php if (!empty($projet['url'])): ?>
            <a href="<?= htmlspecialchars($projet['url']) ?>" target="_blank" class="btn btn-small btn-primary">Accéder au projet</a>
            <?php endif; ?>
            <?php if (!empty($projet['github'])): ?>
            <a href="<?= htmlspecialchars($projet['github']) ?>" target="_blank" class="btn btn-small btn-outline">&#128279; GitHub</a>
            <?php endif; ?>
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

        <?php if (empty($fichiers)): ?>
            <p class="doc-empty">Aucun document déposé — glissez vos fichiers dans <code>documents/<?= $projet['id'] ?>/</code></p>
        <?php else: ?>
            <div class="docs-grid">
                <?php
                $exts_code = ['java', 'php', 'js', 'ts', 'html', 'css', 'xml', 'yml', 'yaml', 'json', 'properties', 'sql'];
                $icones = ['pdf' => '&#128196;', 'java' => '&#9749;', 'xlsm' => '&#128200;', 'xlsx' => '&#128200;', 'pptx' => '&#128221;', 'docx' => '&#128196;'];
                foreach ($fichiers as $fichier):
                    $url  = $url_base . rawurlencode($fichier);
                    $ext  = strtolower(pathinfo($fichier, PATHINFO_EXTENSION));
                    $hash = md5($url);
                    $is_code = in_array($ext, $exts_code);
                    $icone = $icones[$ext] ?? '&#128247;';
                    $url_viewer = '/portefolio/?page=code&projet=' . urlencode($projet['id']) . '&fichier=' . urlencode($fichier);
                ?>
                <div class="card doc-card" id="doc-<?= $hash ?>">
                    <div class="doc-header">
                        <span class="doc-icon"><?= $icone ?></span>
                        <span class="doc-name"><?= htmlspecialchars($fichier) ?></span>
                    </div>
                    <div class="doc-actions">
                        <?php if ($is_code): ?>
                        <a href="<?= $url_viewer ?>" class="btn btn-small btn-primary">Voir le code</a>
                        <?php elseif ($ext === 'pdf'): ?>
                        <a href="<?= $url ?>" target="_blank" class="btn btn-small">Ouvrir</a>
                        <button class="btn btn-small btn-outline" onclick="togglePreview('<?= $hash ?>', '<?= $url ?>')">Aperçu</button>
                        <?php else: ?>
                        <a href="<?= $url ?>" target="_blank" class="btn btn-small">Ouvrir</a>
                        <?php endif; ?>
                        <a href="<?= $url ?>" download class="btn btn-small btn-secondary">Télécharger</a>
                    </div>
                    <?php if ($ext === 'pdf'): ?>
                    <div class="doc-preview" id="preview-<?= $hash ?>" style="display:none;">
                        <iframe src="" data-src="<?= $url ?>" width="100%" height="400" frameborder="0"></iframe>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</section>
