<?php
declare(strict_types=1);

return [
    'title' => 'Elimination Game: last remaining after every-other passes',
    'leetcode' => 390,
    'summary' => 'List 1..n. Alternate LTR/RTL deleting every other value until one remains. n up to 1e9, so do not build the list. Track the current head (and optionally the tail): on a left pass, or when the count is odd, advance head by the gap; then halve the count and double the gap. n=9 → 6. Not one-direction Josephus (1823).',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'kind' => 'algo',
    'tags' => ['math', 'recursion', 'simulation', 'leetcode'],
];
