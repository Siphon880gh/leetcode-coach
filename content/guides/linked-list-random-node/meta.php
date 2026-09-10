<?php
declare(strict_types=1);

return [
    'title' => 'Linked List Random Node: reservoir sampling',
    'leetcode' => 382,
    'summary' => 'getRandom must pick a uniform node when the length may be unknown. Walk from head; at the k-th node replace the answer with probability 1/k (randint(1, k) equals k). [1,2,3] each equally likely. Follow-up: no extra array. Random Pick Index (398) is the same idea on an array.',
    'category' => 'LeetCode',
    'subcategory' => 'Reservoir Sampling',
    'topic' => 'LeetCode · Reservoir Sampling',
    'kind' => 'algo',
    'tags' => ['reservoir-sampling', 'linked-list', 'randomized', 'leetcode'],
    'related_session' => 'linked-list-random-node',
];
