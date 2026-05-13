let PROJETS = [];
let COMPETENCES = {};

async function init() {
    try {
        const [p, c] = await Promise.all([
            fetch('data/projets.json').then(r => r.json()),
            fetch('data/competences.json').then(r => r.json())
        ]);
        PROJETS = p;
        COMPETENCES = c;
    } catch (e) {
        document.getElementById('app').innerHTML = '<p style="padding:2rem;color:#c00">Erreur de chargement des données.</p>';
        return;
    }
    window.addEventListener('hashchange', route);
    route();
}

function route() {
    const raw   = location.hash.slice(1) || 'home';
    const parts = raw.split('/');
    const page  = parts[0];

    updateActiveNav(page);

    switch (page) {
        case 'apropos':     renderApropos();                                        break;
        case 'competences': renderCompetences();                                    break;
        case 'projets':     renderProjets();                                        break;
        case 'documents':   renderDocuments(parts[1]);                              break;
        case 'contact':     renderContact();                                        break;
        case 'code':        renderCode(parts[1], decodeURIComponent(parts[2] || '')); break;
        default:            renderHome();
    }
}

function updateActiveNav(page) {
    document.querySelectorAll('.nav-links a').forEach(a => {
        const target = a.getAttribute('href').replace('#', '');
        a.classList.toggle('active', target === page);
    });
}

function setContent(html) {
    document.getElementById('app').innerHTML = html;
    window.scrollTo(0, 0);
}

function esc(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function escHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

// ── Pages ─────────────────────────────────────────────────────────────────────

function renderHome() {
    setContent(`
        <section class="landing">
            <h1 class="landing-title">Benjamin Boniface</h1>
            <p class="landing-subtitle">BTS SIO option SLAM &mdash; 2025/2026</p>
            <p class="landing-desc">Portfolio de présentation &mdash; Épreuve E5</p>
            <div class="landing-logos">
                <img src="documents/autres/anais.png" alt="Fondation ANAIS">
                <img src="documents/autres/caensup.png" alt="Caen Sup">
            </div>
            <div class="landing-actions">
                <a href="documents/easycleanesat/Projet%20ESAT%20v6.pptx" target="_blank" class="btn btn-primary">&#128221; Présentation EasyCleanESAT</a>
                <a href="#projets" class="btn btn-outline">Voir tous les projets</a>
            </div>
        </section>
        <section class="tableau-synthese-banner">
            <div class="tableau-synthese-card">
                <div class="tableau-synthese-icon">&#128196;</div>
                <div class="tableau-synthese-text">
                    <strong>Tableau de synthèse — Épreuve E5</strong>
                    <span>BTS SIO SLAM &mdash; Session 2026 &mdash; BONIFACE Benjamin</span>
                </div>
                <a href="documents/autres/BTS_SIO_Annexe_VI.5_Epreuve%20E5%20-%20Tableau%20de%20synthe_se_2026.pdf" target="_blank" class="btn btn-primary">Ouvrir le tableau</a>
                <a href="documents/autres/BTS_SIO_Annexe_VI.5_Epreuve%20E5%20-%20Tableau%20de%20synthe_se_2026.pdf" download class="btn btn-secondary">Télécharger</a>
            </div>
        </section>
    `);
}

function renderApropos() {
    setContent(`
        <section class="hero">
            <div class="hero-photo">
                <img src="assets/img/photo.jpg" alt="Photo de Benjamin Boniface" onerror="this.style.display='none'">
            </div>
            <div class="hero-text">
                <h1>Benjamin Boniface</h1>
                <p class="hero-subtitle">BTS SIO option SLAM &mdash; 2025/2026</p>
                <div class="hero-desc">
                    <p>Actuellement en formation BTS SIO option SLAM, je suis en reconversion après une première expérience en qualité, sécurité et environnement dans le secteur industriel.</p>
                    <p>Aujourd'hui moniteur d'atelier en ESAT, j'accompagne des personnes en situation de handicap dans le développement de leurs compétences professionnelles. Ce contexte m'a amené à identifier des besoins concrets en outils numériques adaptés.</p>
                    <p>Je m'oriente vers le développement d'applications métiers utiles, simples et accessibles, avec une attention particulière portée à :</p>
                    <ul class="hero-list">
                        <li>L'analyse des besoins réels</li>
                        <li>La modélisation de systèmes d'information</li>
                        <li>La conception de solutions adaptées aux utilisateurs</li>
                    </ul>
                    <p>Mon objectif est de mettre l'informatique au service du terrain, notamment dans le secteur médico-social.</p>
                </div>
                <div class="hero-actions">
                    <a href="#projets" class="btn btn-primary">Voir mes projets</a>
                    <a href="#documents" class="btn btn-secondary">Documents E5</a>
                </div>
            </div>
        </section>
        <section class="highlights">
            <div class="card"><h3>Formation</h3><p>BTS SIO &mdash; SLAM</p><p>2025/2026</p></div>
            <div class="card"><h3>Option</h3><p>SLAM &mdash; Solutions Logicielles et Applications Métiers</p></div>
            <div class="card"><h3>Épreuve</h3><p>E5 &mdash; Production et fourniture de services informatiques</p></div>
        </section>
    `);
}

function renderCompetences() {
    const idx = {};
    PROJETS.forEach(p => idx[p.id] = p);

    let html = `
        <section class="page-section">
            <h2 class="page-title">Compétences E5</h2>
            <p class="page-intro">Référentiel de compétences de l'épreuve E5 — une compétence validée par bloc est indiquée par un lien vers les preuves correspondantes.</p>`;

    for (const [blocId, bloc] of Object.entries(COMPETENCES)) {
        html += `
            <div class="bloc">
                <h3 class="bloc-title"><span class="bloc-ref">${esc(blocId)}</span> ${esc(bloc.label)}</h3>
                <div class="competences-grid">`;

        for (const comp of bloc.competences) {
            const validee = comp.projets && comp.projets.length > 0;
            html += `<div class="card competence-card ${validee ? 'validee' : ''}">
                <div class="comp-header">
                    <span class="comp-ref">${esc(comp.ref)}</span>
                    <span class="comp-label">${esc(comp.label)}</span>
                </div>`;
            if (validee) {
                html += `<div class="comp-projets">`;
                for (const pid of comp.projets) {
                    if (!idx[pid]) continue;
                    html += `<a href="#documents/${pid}" class="comp-projet-link">&#128196; ${esc(idx[pid].titre)}</a>`;
                }
                html += `</div>`;
            }
            html += `</div>`;
        }
        html += `</div></div>`;
    }
    html += `</section>`;
    setContent(html);
}

function renderProjets() {
    let html = `
        <section class="page-section">
            <h2 class="page-title">Projets &amp; Situations</h2>
            <p class="page-intro">Situations professionnelles présentées lors de l'épreuve E5.</p>
            <div class="projets-grid">`;

    for (const p of PROJETS) {
        const nbDocs = (p.fichiers || []).length;
        html += `
            <div class="card projet-card">
                <div class="projet-header">
                    <h3>${esc(p.titre)}</h3>
                    <span class="badge">${esc(p.contexte)}</span>
                </div>
                <p class="projet-desc">${esc(p.description)}</p>
                <div class="projet-tech">
                    ${p.technologies.map(t => `<span class="tag">${esc(t)}</span>`).join('')}
                </div>`;

        if (p.preuves && p.preuves.length) {
            html += `<div class="preuves-attendues">
                <p class="preuves-label">Preuves attendues :</p>
                <ul>${p.preuves.map(v => `<li>${esc(v)}</li>`).join('')}</ul>
            </div>`;
        }

        html += `<div class="projet-footer">`;
        if (p.url)    html += `<a href="${esc(p.url)}" target="_blank" class="btn btn-primary btn-small">Accéder au projet</a>`;
        if (p.github) html += `<a href="${esc(p.github)}" target="_blank" class="btn btn-outline btn-small">&#128279; GitHub</a>`;
        html += `<a href="#documents/${p.id}" class="btn btn-secondary btn-small">Preuves <span class="doc-count ${nbDocs === 0 ? 'empty' : ''}">${nbDocs}</span></a>`;
        html += `</div></div>`;
    }
    html += `</div></section>`;
    setContent(html);
}

function renderDocuments(anchor) {
    const EXTS_CODE = ['java', 'php', 'js', 'ts', 'html', 'css', 'xml', 'yml', 'yaml', 'json', 'properties', 'sql'];
    const ICONES    = { pdf: '&#128196;', java: '&#9749;', xlsm: '&#128200;', xlsx: '&#128200;', pptx: '&#128221;', docx: '&#128196;' };

    // Index ref → label depuis les compétences
    const compLabels = {};
    for (const bloc of Object.values(COMPETENCES)) {
        for (const comp of bloc.competences) {
            compLabels[comp.ref] = comp.label;
        }
    }

    let html = `
        <section class="page-section">
            <h2 class="page-title">Documents de preuve</h2>
            <p class="page-intro">Preuves classées par situation, consultables et téléchargeables par le jury.</p>`;

    for (const p of PROJETS) {
        html += `<div class="doc-category" id="${esc(p.id)}">
            <div class="doc-cat-header">
                <div>
                    <h3 class="doc-cat-title">${esc(p.titre)}</h3>
                    <p class="doc-cat-desc">${esc(p.contexte)}</p>
                </div>`;
        if (p.url)    html += `<a href="${esc(p.url)}" target="_blank" class="btn btn-small btn-primary">Accéder au projet</a>`;
        if (p.github) html += `<a href="${esc(p.github)}" target="_blank" class="btn btn-small btn-outline">&#128279; GitHub</a>`;
        html += `</div>`;

        if (p.preuves && p.preuves.length) {
            html += `<div class="preuves-attendues"><p class="preuves-label">Preuves attendues :</p>
                <ul>${p.preuves.map(v => `<li>${esc(v)}</li>`).join('')}</ul>
            </div>`;
        }

        const fichiers = p.fichiers || [];
        if (fichiers.length === 0) {
            html += `<p class="doc-empty">Aucun document déposé.</p>`;
        } else {
            html += `<div class="docs-grid">`;
            fichiers.forEach((fichier, i) => {
                const ext    = fichier.split('.').pop().toLowerCase();
                const isCode = EXTS_CODE.includes(ext);
                const icone  = ICONES[ext] || '&#128247;';
                const fileId = `${p.id}-${i}`;
                const url    = `documents/${p.id}/${encodeURIComponent(fichier)}`;

                const compRef   = (p.fichiers_competences || {})[fichier];
                const compLabel = compRef ? compLabels[compRef] : null;

                html += `<div class="card doc-card" id="doc-${fileId}">
                    <div class="doc-header">
                        <span class="doc-icon">${icone}</span>
                        <span class="doc-name">${esc(fichier)}</span>
                    </div>
                    ${compRef ? `<div class="doc-comp-badge"><span class="doc-comp-ref">${esc(compRef)}</span> ${compLabel ? esc(compLabel) : ''}</div>` : ''}
                    <div class="doc-actions">`;

                if (isCode) {
                    html += `<a href="#code/${p.id}/${encodeURIComponent(fichier)}" class="btn btn-small btn-primary">Voir le code</a>`;
                } else if (ext === 'pdf') {
                    html += `<a href="${url}" target="_blank" class="btn btn-small">Ouvrir</a>
                        <button class="btn btn-small btn-outline" onclick="togglePreview('${fileId}', '${url}')">Aperçu</button>`;
                } else {
                    html += `<a href="${url}" target="_blank" class="btn btn-small">Ouvrir</a>`;
                }

                html += `<a href="${url}" download class="btn btn-small btn-secondary">Télécharger</a>
                    </div>`;

                if (ext === 'pdf') {
                    html += `<div class="doc-preview" id="preview-${fileId}" style="display:none;">
                        <iframe src="" data-src="${url}" width="100%" height="400" frameborder="0"></iframe>
                    </div>`;
                }
                html += `</div>`;
            });
            html += `</div>`;
        }
        html += `</div>`;
    }
    html += `</section>`;
    setContent(html);

    if (anchor) {
        setTimeout(() => {
            const el = document.getElementById(anchor);
            if (el) el.scrollIntoView({ behavior: 'smooth' });
        }, 50);
    }
}

function renderContact() {
    setContent(`
        <section class="page-section contact-section">
            <h2 class="page-title">Informations personnelles</h2>

            <div class="cv-banner card">
                <div class="cv-banner-text">
                    <span class="cv-banner-icon">&#128196;</span>
                    <div>
                        <strong>Curriculum Vitae</strong>
                        <span>Benjamin Boniface — BTS SIO SLAM 2025/2026</span>
                    </div>
                </div>
                <div class="cv-banner-actions">
                    <a href="documents/autres/Benjamin%20Boniface-Cv%20portfolio%20E5.pdf" target="_blank" class="btn btn-primary">Ouvrir</a>
                    <a href="documents/autres/Benjamin%20Boniface-Cv%20portfolio%20E5.pdf" download class="btn btn-secondary">Télécharger</a>
                </div>
            </div>

            <div class="contact-card card">
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="contact-icon">&#9993;</span>
                        <span>benjaminboniface@hotmail.fr</span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">&#128736;</span>
                        <a href="https://github.com/Boniben" target="_blank">GitHub</a>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">&#128101;</span>
                        <a href="https://www.linkedin.com/in/benjamin-boniface-7a7b6313b/" target="_blank">LinkedIn</a>
                    </div>
                </div>
                <div class="contact-formation">
                    <p><strong>Formation :</strong> BTS SIO option SLAM</p>
                    <p><strong>Année :</strong> 2025/2026</p>
                </div>
            </div>
        </section>
    `);
}

async function renderCode(projetId, fichier) {
    if (!projetId || !fichier) { location.hash = '#documents'; return; }

    const projet = PROJETS.find(p => p.id === projetId);
    if (!projet)  { location.hash = '#documents'; return; }

    const url = `documents/${projetId}/${encodeURIComponent(fichier)}`;
    const ext = fichier.split('.').pop().toLowerCase();

    setContent(`<p style="padding:2rem;color:var(--text-muted)">Chargement…</p>`);

    try {
        const resp = await fetch(url);
        if (!resp.ok) throw new Error();
        const contenu = await resp.text();

        setContent(`
            <p class="code-breadcrumb">
                <a href="#documents/${projetId}">← Documents</a>
                &nbsp;/&nbsp; ${esc(projet.titre)}
                &nbsp;/&nbsp; ${esc(fichier)}
            </p>
            <div class="code-header">
                <h2>${esc(fichier)}</h2>
                <a href="${url}" download class="btn btn-secondary btn-small">Télécharger</a>
            </div>
            <div class="code-wrap">
                <pre><code class="language-${ext}">${escHtml(contenu)}</code></pre>
            </div>
        `);
        document.querySelectorAll('pre code').forEach(el => hljs.highlightElement(el));
    } catch {
        setContent(`<p style="padding:2rem;color:var(--text-muted)">Impossible de charger le fichier.</p>`);
    }
}

// ── Utilitaires ───────────────────────────────────────────────────────────────

function togglePreview(id, url) {
    const preview = document.getElementById('preview-' + id);
    if (!preview) return;
    const isOpen = preview.style.display !== 'none';
    if (isOpen) {
        preview.style.display = 'none';
    } else {
        const iframe = preview.querySelector('iframe');
        if (iframe && !iframe.src) iframe.src = iframe.getAttribute('data-src');
        preview.style.display = 'block';
    }
}

document.getElementById('navToggle').addEventListener('click', () => {
    document.getElementById('navLinks').classList.toggle('open');
});

// ── Démarrage ─────────────────────────────────────────────────────────────────

init();
