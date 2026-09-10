<?php
declare(strict_types=1);

return [
    'title' => 'Maximum Product of Word Lengths: bitmasks, AND is zero',
    'leetcode' => 318,
    'summary' => 'Walk a deterministic path: max len(i) × len(j) for two words with no shared letter. Pack each word’s letters into a 26-bit mask. Pairwise AND == 0 means disjoint; then multiply lengths. [“abcw”,“xtfn”] → 16. All a’s → 0. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'tags' => ['bit-manipulation', 'strings', 'step-by-step'],
    'related_guide' => 'maximum-product-of-word-lengths',
];
