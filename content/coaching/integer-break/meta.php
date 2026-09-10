<?php
declare(strict_types=1);

return [
    'title' => 'Integer Break: prefer 3s, never leave a leftover 1',
    'leetcode' => 343,
    'summary' => 'Walk a deterministic path: split n into at least two positive integers; maximize the product. Prefer as many 3s as possible. Leftover 4 → 2+2, not 3+1. n=2 → 1; n=10 → 36. Math is O(1); DP is O(n²). Must split (k ≥ 2). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'math', 'integer-break', 'step-by-step'],
    'related_guide' => 'integer-break',
];
