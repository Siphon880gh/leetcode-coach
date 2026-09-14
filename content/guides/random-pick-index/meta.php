<?php
declare(strict_types=1);

return [
    'title' => 'Random Pick Index: reservoir — replace on the k-th match',
    'leetcode' => 398,
    'difficulty' => 'Med',
    'summary' => 'pick(target) must return a uniform random index among all i where nums[i] equals target. Scan once; on the k-th match, replace the answer with probability 1/k (randint(1, k) equals k). [1,2,3,3,3] pick(3) → 2, 3, or 4 equally. Follow-up: no index map. Linked List Random Node (382) is the same idea on a list.',
    'category' => 'LeetCode',
    'subcategory' => 'Reservoir Sampling',
    'topic' => 'LeetCode · Reservoir Sampling',
    'kind' => 'algo',
    'tags' => ['reservoir-sampling', 'randomized', 'hash-table', 'leetcode'],
    'related_session' => 'random-pick-index',
];
