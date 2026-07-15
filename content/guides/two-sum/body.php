<?php
declare(strict_types=1);

$promptGame = <<<'PROMPT'
Use the harness skill at .agents/skills/harness to create a mini-game in this Algo Learning IDE app that teaches Two Sum with a hash map (seen / complement). Place it under content/games/, follow the meta.php + index.html contract, and optionally use .agents/skills/game-development-sickn33 for web/2d craft.
PROMPT;

$promptCoach = <<<'PROMPT'
Use the harness skill at .agents/skills/harness to create a coaching session for Two Sum under content/coaching/. Include branching choices, at least one wrong-path leaf with rewind_to, and a success leaf. Follow the tree.php node contract so Step back works in the UI.
PROMPT;
?>

<p>
    Given an array of integers <code>nums</code> and an integer <code>target</code>, return the indices of the
    two numbers that add up to <code>target</code>. You may assume exactly one solution, and you may not use the same element twice.
</p>

<h2>Why brute force hurts</h2>
<p>
    Checking every pair is <code>O(n²)</code> time. For interview and contest scale, that is usually too slow —
    and it wastes the structure of the problem: for each value <code>x</code>, you only need to know whether
    <code>target - x</code> already appeared.
</p>

<div class="complexity">
    <div class="complexity__item">
        <span class="complexity__label">Brute force</span>
        Time O(n²) · Space O(1)
    </div>
    <div class="complexity__item">
        <span class="complexity__label">Hash map (goal)</span>
        Time O(n) · Space O(n)
    </div>
</div>

<h2>One-pass hash map</h2>
<ul>
    <li>Walk the array left to right.</li>
    <li>At index <code>i</code>, compute <code>need = target - nums[i]</code>.</li>
    <li>If <code>need</code> is already in the map, return <code>[map[need], i]</code>.</li>
    <li>Otherwise store <code>nums[i] → i</code> and continue.</li>
</ul>
<p>
    Each lookup and insert is amortized O(1), so the whole pass is <strong>O(n)</strong> time and <strong>O(n)</strong> extra space
    for the map. That space/time tradeoff is the pattern to remember for “find a pair / complement” array problems.
</p>

<h2>Prompt Cursor for another session</h2>
<p>
    If this still feels abstract, stay in this repo and ask Cursor to use <code>.agents/skills/harness</code>
    to build a related mini-game or coaching path that appears in this IDE.
</p>

<div class="prompt-block" style="margin-bottom: 1rem;">
    <div class="prompt-block__actions">
        <button type="button" class="btn btn--small btn--ghost" data-copy-target="#guide-prompt-game" style="color: var(--code-ink); border-color: #5a6a6a;">Copy prompt</button>
    </div>
    <pre id="guide-prompt-game"><?= e($promptGame) ?></pre>
</div>

<div class="prompt-block">
    <div class="prompt-block__actions">
        <button type="button" class="btn btn--small btn--ghost" data-copy-target="#guide-prompt-coach" style="color: var(--code-ink); border-color: #5a6a6a;">Copy prompt</button>
    </div>
    <pre id="guide-prompt-coach"><?= e($promptCoach) ?></pre>
</div>
