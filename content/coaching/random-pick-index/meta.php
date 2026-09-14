<?php
declare(strict_types=1);

return [
    'title' => 'Random Pick Index: reservoir — replace on the k-th match',
    'leetcode' => 398,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: pick(target) returns a uniform random index among matches. Scan once; on the k-th match, replace the answer with probability 1/k. [1,2,3,3,3] pick(3) → 2, 3, or 4 equally. Follow-up needs no index map. Same idea as 382. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Reservoir Sampling',
    'topic' => 'LeetCode · Reservoir Sampling',
    'tags' => ['reservoir-sampling', 'randomized', 'hash-table', 'step-by-step'],
    'related_guide' => 'random-pick-index',
];
