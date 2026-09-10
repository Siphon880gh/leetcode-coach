<?php
declare(strict_types=1);

return [
    'title' => 'Create Maximum Number: pick k from each, merge by suffix',
    'leetcode' => 321,
    'summary' => 'Max length-k subsequence using both arrays, order preserved inside each. For every split x + (k−x), drop extras with a monotonic stack, then merge by comparing remaining suffixes. [3,4,6,5] and [9,1,2,5,8,3], k = 5 → [9,8,6,5,3].',
    'category' => 'LeetCode',
    'subcategory' => 'Monotonic Stack',
    'topic' => 'LeetCode · Monotonic Stack',
    'kind' => 'algo',
    'tags' => ['monotonic-stack', 'greedy', 'two-pointers', 'leetcode'],
    'related_session' => 'create-maximum-number',
];
