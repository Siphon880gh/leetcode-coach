<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';

$examplePrompt = <<<'PROMPT'
Use the harness skill at .agents/skills/harness to create a step-by-step session in this Algo Learning IDE app for the Two Sum problem (LeetCode arrays). Follow the content/coaching contract, include at least one wrong-path leaf with rewind, and wire meta.php + tree.php so it appears under Step-by-step.
PROMPT;

layout_start([
    'title' => 'Algo Learning IDE with UI',
    'description' => 'Interactive Cursor harness extension for system design, DSA, and LeetCode study.',
    'active' => 'home',
]);
?>

<section class="hero">
    <p class="hero__eyebrow">Cursor harness · study extension</p>
    <h1 class="hero__brand">Algo Learning IDE with UI</h1>
    <p class="hero__lead">
        For students of system design, data structures, algorithms, and LeetCode.
        An interactive extension of the Cursor harness — learn here, then prompt Cursor to build the next guide, mini-game, or step-by-step path inside this app.
    </p>
    <aside class="hero__note" aria-labelledby="concept-note-title">
        <h2 id="concept-note-title">This is not a coding test</h2>
        <p>
            This app does not test you on coding the solutions. It focuses on applying the concepts without writing code.
            After you work through a problem here, the next step is to implement it in your preferred language on LeetCode.
        </p>
        <p>
            Each resource that maps to a LeetCode problem shows that number. Visit the
            <a href="https://leetcode.com/problemset/" target="_blank" rel="noopener noreferrer">LeetCode problemset</a>
            — the problems are numbered there — so you can get the coding practice when you are ready.
            This app does not link to those problems directly.
        </p>
        <p>
            The idea is not to replace LeetCode. It adds a language-free concept-application phase.
            Coding a solution is a lot harder if you do not have the concept yet.
        </p>
    </aside>
    <div class="cta-row">
        <a class="btn btn--primary" href="<?= e(guide_list_url('algo')) ?>">Algo Guides</a>
        <a class="btn btn--ghost" href="<?= e(guide_list_url('cursor')) ?>">Cursor AI Guides</a>
        <a class="btn btn--ghost" href="<?= e(url('games/index.php')) ?>">Mini games</a>
        <a class="btn btn--ghost" href="<?= e(url('coaching/index.php')) ?>">Step-by-step</a>
    </div>
</section>

<section class="prompt-strip" aria-labelledby="prompt-help-title">
    <h2 id="prompt-help-title">Theory unclear? Prompt Cursor for another session</h2>
    <p>
        When a concept does not click, open this repo in Cursor and ask it to use
        <code>.agents/skills/harness</code>. That skill creates Algo Guides, Cursor AI Guides, mini games, and deterministic step-by-step wizards that show up in this IDE.
    </p>
    <div class="prompt-block">
        <div class="prompt-block__actions">
            <button type="button" class="btn btn--small btn--ghost" data-copy-target="#hub-example-prompt" style="color: var(--code-ink); border-color: #5a6a6a;">Copy prompt</button>
        </div>
        <pre id="hub-example-prompt"><?= e($examplePrompt) ?></pre>
    </div>
</section>

<?php
layout_end();
