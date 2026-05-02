<section class="hero">
    <div class="hero-photo">
        <img src="/portefolio/assets/img/photo.jpg" alt="Photo de <?= STUDENT_NAME ?>" onerror="this.style.display='none'">
    </div>
    <div class="hero-text">
        <h1><?= STUDENT_NAME ?></h1>
        <p class="hero-subtitle"><?= FORMATION ?> option <?= OPTION ?> &mdash; <?= ANNEE ?></p>
        <div class="hero-desc">
            <p>
                Actuellement en formation BTS SIO option SLAM, je suis en reconversion après une première expérience en qualité, sécurité et environnement dans le secteur industriel.
            </p>
            <p>
                Aujourd'hui moniteur d'atelier en ESAT, j'accompagne des personnes en situation de handicap dans le développement de leurs compétences professionnelles. Ce contexte m'a amené à identifier des besoins concrets en outils numériques adaptés.
            </p>
            <p>Je m'oriente vers le développement d'applications métiers utiles, simples et accessibles, avec une attention particulière portée à :</p>
            <ul class="hero-list">
                <li>L'analyse des besoins réels</li>
                <li>La modélisation de systèmes d'information</li>
                <li>La conception de solutions adaptées aux utilisateurs</li>
            </ul>
            <p>Mon objectif est de mettre l'informatique au service du terrain, notamment dans le secteur médico-social.</p>
        </div>
        <div class="hero-actions">
            <a href="/portefolio/?page=projets" class="btn btn-primary">Voir mes projets</a>
            <a href="/portefolio/?page=documents" class="btn btn-secondary">Documents E5</a>
        </div>
    </div>
</section>

<section class="highlights">
    <div class="card">
        <h3>Formation</h3>
        <p><?= FORMATION ?> &mdash; <?= OPTION ?></p>
        <p>Lycée / CFA &mdash; <?= ANNEE ?></p>
    </div>
    <div class="card">
        <h3>Option</h3>
        <p>SLAM &mdash; Solutions Logicielles et Applications Métiers</p>
    </div>
    <div class="card">
        <h3>Épreuve</h3>
        <p>E5 &mdash; Production et fourniture de services informatiques</p>
    </div>
</section>
