<section class="page-section contact-section">
    <h2 class="page-title">Contact</h2>

    <div class="contact-card card">
        <div class="contact-info">
            <div class="contact-item">
                <span class="contact-icon">&#9993;</span>
                <span><?= htmlspecialchars(EMAIL) ?></span>
            </div>
            <?php if (GITHUB): ?>
            <div class="contact-item">
                <span class="contact-icon">&#128736;</span>
                <a href="<?= htmlspecialchars(GITHUB) ?>" target="_blank">GitHub</a>
            </div>
            <?php endif; ?>
            <?php if (LINKEDIN): ?>
            <div class="contact-item">
                <span class="contact-icon">&#128101;</span>
                <a href="<?= htmlspecialchars(LINKEDIN) ?>" target="_blank">LinkedIn</a>
            </div>
            <?php endif; ?>
        </div>
        <div class="contact-formation">
            <p><strong>Formation :</strong> <?= FORMATION ?> option <?= OPTION ?></p>
            <p><strong>Année :</strong> <?= ANNEE ?></p>
        </div>
    </div>
</section>
