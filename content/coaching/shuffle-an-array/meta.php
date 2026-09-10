<?php
declare(strict_types=1);

return [
    'title' => 'Shuffle an Array: Fisher–Yates plus a stored original',
    'leetcode' => 384,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: keep a copy of nums for reset. shuffle walks i from 0 and swaps i with a uniform index in [i, n). Every permutation equally likely. [1,2,3] reset → [1,2,3]. Do not swap with a random in [0, n) each step (biased). Not 380 getRandom. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Randomized',
    'topic' => 'LeetCode · Randomized',
    'tags' => ['randomized', 'design', 'arrays', 'fisher-yates', 'step-by-step'],
    'related_guide' => 'shuffle-an-array',
];
