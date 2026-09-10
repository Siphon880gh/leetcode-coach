<?php
declare(strict_types=1);

return [
    'title' => 'Shuffle an Array: Fisher–Yates plus a stored original',
    'leetcode' => 384,
    'summary' => 'Keep a copy of nums for reset. shuffle walks i from 0 and swaps i with a uniform index in [i, n). Every permutation equally likely. [1,2,3] → some permutation, reset → [1,2,3]. Do not swap with a random in [0, n) each step (biased). Not 380 getRandom.',
    'category' => 'LeetCode',
    'subcategory' => 'Randomized',
    'topic' => 'LeetCode · Randomized',
    'kind' => 'algo',
    'tags' => ['randomized', 'design', 'arrays', 'fisher-yates', 'leetcode'],
    'related_session' => 'shuffle-an-array',
];
