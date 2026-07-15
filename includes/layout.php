<?php
declare(strict_types=1);

require_once __DIR__ . '/content.php';

/**
 * @param array{title?: string, description?: string, active?: string} $opts
 */
function layout_start(array $opts = []): void
{
    $title = $opts['title'] ?? 'Algo Learning IDE with UI';
    $description = $opts['description'] ?? 'Interactive Cursor harness extension for system design, data structures, algorithms, and LeetCode.';
    $active = $opts['active'] ?? '';
    $pageTitle = $title === 'Algo Learning IDE with UI'
        ? $title
        : $title . ' · Algo Learning IDE with UI';
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($description) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('assets/css/app.css')) ?>">
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>
    <header class="site-header">
        <div class="site-header__inner">
            <a class="brand" href="<?= e(url('index.php')) ?>">
                <span class="brand__mark">AL</span>
                <span class="brand__text">Algo Learning IDE with UI</span>
            </a>
            <nav class="nav" aria-label="Primary">
                <a class="nav__link<?= $active === 'guides-cursor' ? ' is-active' : '' ?>" href="<?= e(guide_list_url('cursor')) ?>">Cursor AI Guides</a>
                <a class="nav__link<?= $active === 'guides-algo' ? ' is-active' : '' ?>" href="<?= e(guide_list_url('algo')) ?>">Algo Guides</a>
                <a class="nav__link<?= $active === 'games' ? ' is-active' : '' ?>" href="<?= e(url('games/index.php')) ?>">Mini games</a>
                <a class="nav__link<?= $active === 'coaching' ? ' is-active' : '' ?>" href="<?= e(url('coaching/index.php')) ?>">Step-by-step</a>
            </nav>
        </div>
    </header>
    <main id="main" class="main">
    <?php
}

function layout_end(): void
{
    ?>
    </main>
    <footer class="site-footer">
        <div class="site-footer__inner">
            <p>For students of system design, data structures, algorithms, and LeetCode.</p>
            <p class="site-footer__muted">Interactive extension of the Cursor harness — prompt Cursor with <code>.agents/skills/harness</code> to create new guides, games, or step-by-step sessions.</p>
            <details class="site-credits">
                <summary class="site-credits__toggle">Credits</summary>
                <div class="site-credits__body">
                    <p class="site-credits__by">By Weng (Weng Fei Fung)</p>
                    <p class="site-credits__badges">
                        <img src="https://img.shields.io/github/last-commit/Siphon880gh/leetcode-coach/main" alt="Last Commit" height="20">
                        <a target="_blank" href="https://github.com/Siphon880gh" rel="noopener noreferrer">
                            <img src="https://img.shields.io/badge/GitHub--blue?style=social&amp;logo=GitHub" alt="GitHub" height="20">
                        </a>
                        <a target="_blank" href="https://www.linkedin.com/in/weng-fung/" rel="noopener noreferrer">
                            <img src="https://img.shields.io/badge/LinkedIn-blue?style=flat&amp;logo=linkedin&amp;labelColor=blue" alt="LinkedIn" height="20">
                        </a>
                        <a target="_blank" href="https://www.youtube.com/@WayneTeachesCode/" rel="noopener noreferrer">
                            <img src="https://img.shields.io/badge/Youtube-red?style=flat&amp;logo=youtube&amp;labelColor=red" alt="YouTube" height="20">
                        </a>
                    </p>
                </div>
            </details>
        </div>
    </footer>
    <script src="<?= e(url('assets/js/app.js')) ?>" defer></script>
</body>
</html>
    <?php
}
