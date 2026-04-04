<?php
$pageTitle = 'HistInt - Accueil';
$showNavigation = false;
require_once __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/header.php';
?>

<main class="landing-page">
    <section class="hero">
        <div class="hero-bg">
            <div class="fog fog-1"></div>
            <div class="fog fog-2"></div>
            <div class="embers" id="embers"></div>
            <div class="stars"></div>
        </div>

        <div class="hero-content">
            <p class="eyebrow">Chronique interactive médiévale</p>
            <h1 class="hero-title">Les Ombres de Valdremor</h1>
            <p class="hero-subtitle">
                Une histoire de feu, de cendres, de secrets anciens et d’héritage caché.
            </p>

            <div class="hero-actions">
                <a href="scene.php?scene=scene_01&start=new" class="btn btn-primary">Commencer l’histoire</a>
                <a href="#about-story" class="btn btn-secondary">Découvrir l’univers</a>
            </div>
        </div>
    </section>

    <section class="intro-card reveal">
        <div class="intro-grid">
            <div class="intro-text">
                <p class="section-kicker">Bienvenue</p>
                <h2>Entre dans un monde de cendres, de forêts et de vérités interdites</h2>
                <p>
                    Thornwick brûle. Kael, jeune forgeron, voit sa vie basculer en une seule nuit.
                    Entre la disparition des repères, les silhouettes encapuchonnées et les secrets
                    laissés par son père, chaque choix ouvre un nouveau chemin.
                </p>
                <p>
                    Ce projet est une histoire interactive textuelle : tu avances scène par scène,
                    explores plusieurs branches du récit, et découvres progressivement ce qui relie
                    le village en flammes, la forêt de Valdremor, la Tour de Sel et la Confrérie des Cendres.
                </p>
            </div>

            <!-- <div class="intro-quote">
                <div class="quote-box">
                    <p>
                        “Le feu détruit les maisons. Les secrets détruisent les lignées.”
                    </p>
                    <span>Chronique de Valdremor</span>
                </div> -->
            </div>
        </div>
    </section>

    <section id="about-story" class="about-grid">
        <article class="info-card reveal">
            <p class="section-kicker">À propos</p>
            <h3>Qu’est-ce que c’est ?</h3>
            <p>
                <strong>Les Ombres de Valdremor</strong> est une fiction interactive médiévale-fantastique.
                Le joueur suit Kael et prend des décisions qui modifient la direction du récit.
            </p>
            <p>
                L’histoire repose sur une structure à embranchements avec plusieurs actes, de nombreuses
                scènes et plusieurs fins possibles.
            </p>
        </article>

        <article class="info-card reveal">
            <p class="section-kicker">Structure</p>
            <h3>Comment ça fonctionne ?</h3>
            <ul class="feature-list">
                <li>Une scène = un moment narratif important</li>
                <li>Trois choix principaux à la plupart des étapes</li>
                <li>Des chemins différents selon les décisions prises</li>
                <li>Une progression du mystère jusqu’aux révélations finales</li>
            </ul>
        </article>

        <article class="info-card reveal">
            <p class="section-kicker">Atmosphère</p>
            <h3>Quel ton ?</h3>
            <p>
                L’univers mélange feu, ruines, magie froide, forêts anciennes, confréries secrètes
                et héritage familial tragique. Le ton est sombre, mystérieux et centré sur le récit.
            </p>
        </article>
    </section>

    <section class="timeline-section reveal">
        <p class="section-kicker">Parcours</p>
        <h2>Le voyage de Kael</h2>

        <div class="timeline">
            <div class="timeline-step">
                <span class="timeline-number">I</span>
                <div>
                    <h4>La nuit du départ</h4>
                    <p>Le village brûle, Mira est en danger, et tout commence dans le chaos.</p>
                </div>
            </div>

            <div class="timeline-step">
                <span class="timeline-number">II</span>
                <div>
                    <h4>La forêt de Valdremor</h4>
                    <p>La fuite ouvre la porte à des signes étranges, des visions et des avertissements.</p>
                </div>
            </div>

            <div class="timeline-step">
                <span class="timeline-number">III</span>
                <div>
                    <h4>Les révélations</h4>
                    <p>Le passé de Daren, la Confrérie et le Sceau commencent à émerger.</p>
                </div>
            </div>

            <div class="timeline-step">
                <span class="timeline-number">IV</span>
                <div>
                    <h4>Le choix final</h4>
                    <p>Le destin de Kael, de Mira et de Valdremor dépend des décisions prises.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section reveal">
        <div class="cta-box">
            <p class="section-kicker">Commencer</p>
            <h2>La première nuit t’attend</h2>
            <p>
                Entre dans Thornwick au moment où les flammes dévorent les granges, où les cris
                résonnent dans les ruelles, et où ton premier choix décidera déjà du ton de ton destin.
            </p>
            <a href="scene.php?scene=scene_01&start=new" class="btn btn-primary btn-large">Entrer dans l’histoire</a>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
