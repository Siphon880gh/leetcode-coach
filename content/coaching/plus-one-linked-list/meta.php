<?php
declare(strict_types=1);

return [
    'title' => 'Plus One Linked List: last non-nine, then zero the tail',
    'leetcode' => 369,
    'summary' => 'Walk a deterministic path: digits MSD at the head. Dummy 0 in front. Remember the last node that is not 9, add 1 there, set every node after it to 0. If dummy becomes 1, return dummy. [1,2,3] → [1,2,4]. Not 66. Not 2. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Linked List',
    'topic' => 'LeetCode · Linked List',
    'tags' => ['linked-list', 'math', 'carry', 'step-by-step'],
    'related_guide' => 'plus-one-linked-list',
];
