<?php
declare(strict_types=1);

return [
    'title' => 'Linked List Random Node: reservoir sampling',
    'leetcode' => 382,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: getRandom must pick a uniform node when the length may be unknown. Walk from head; at the k-th node replace the answer with probability 1/k. [1,2,3] each equally likely. Follow-up: no extra array. Not 380. Not 398 as a stored index map. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Reservoir Sampling',
    'topic' => 'LeetCode · Reservoir Sampling',
    'tags' => ['reservoir-sampling', 'linked-list', 'randomized', 'step-by-step'],
    'related_guide' => 'linked-list-random-node',
];
