<?php
declare(strict_types=1);

return [
    'title' => 'Elimination Game: last remaining after every-other passes',
    'leetcode' => 390,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: list 1..n. Alternate LTR/RTL deleting every other value until one remains. n up to 1e9, so do not build the list. Track the current head: on a left pass, or when the count is odd, advance head by the gap; then halve the count and double the gap. n=9 → 6. Not one-direction Josephus (1823). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'recursion', 'simulation', 'step-by-step'],
    'related_guide' => 'elimination-game',
];
