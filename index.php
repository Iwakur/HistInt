<?php
declare(strict_types=1);

$pageTitle = 'HistInt - Accueil';
$showNavigation = false;
session_start();
require_once __DIR__ . '/includes/functions.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logoutUser();
}

if ($_SESSION['message'] ?? false) {
echo '<script>alert("' . e($_SESSION['message']) . '")</script>';
    unset($_SESSION['message']);
}

$user = currentUser();

require __DIR__ . '/includes/header.php';
?>

<main class="landing-page">
    <section class="hero">
    

        <div class="hero-content">
            <p class="eyebrow">Chronique interactive médiévale</p>

            <h1 class="hero-title">Les Ombres de Valdremor</h1>

            <p class="hero-subtitle">
                Une histoire de feu, de cendres, de secrets anciens et d’héritage caché.
            </p>

            <div class="hero-actions">
                <?php if ($user): ?>
                    <a href="scene.php?scene=<?= e($user['current_scene']) ?>" class="btn btn-primary">
                        Reprendre
                    </a>

                    <a href="scene.php?scene=scene_01&start=new" class="btn btn-secondary">
                        Nouvelle partie
                    </a>

                    <a href="index.php?action=logout" class="btn btn-secondary">
                        Déconnexion
                    </a>
                <?php else: ?>
                    <a href="scene.php?scene=scene_01" class="btn btn-primary">
                        Nouvelle partie
                    </a>

                    <a href="login.php" class="btn btn-secondary">
                        Connexion
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="intro-card reveal">
        <div class="content-wrapper">
            <p class="section-kicker">Projet Portes Ouvertes</p>

            <h2>Bienvenue </h2>
            <p>
                Thornwick brûle. Kael, jeune forgeron, voit sa vie basculer en une seule nuit.
                Entre la disparition de ses repères, l'ombre des silhouettes encapuchonnées et les secrets
                laissés par son père, chaque choix devient une nouvelle branche de son destin.
            </p>

            <p>
                <strong>Une métamorphose numérique :</strong>
                Ce projet s'inspire des classiques « Livres dont vous êtes le héros ».
                Là où les pages se tournaient autrefois à la main, le web permet aujourd'hui
                une expérience fluide et interactive. C'est une évolution du récit : vous explorez
                les profondeurs de la forêt de Valdremor et les mystères de la Tour de Sel à travers
                une interface dynamique où vos décisions sculptent l'histoire en temps réel.
            </p>

            <div class="credits">
                <p><strong>Créé par l'équipe :</strong> Hlib, Clément, Théo, Harry, Ashley</p>
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
                L’histoire repose sur une structure à embranchements avec plusieurs actes,
                de nombreuses scènes et plusieurs fins possibles.
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
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>