<?php
declare(strict_types=1);

return [
    'title' => 'Odd Even Linked List: stitch odd indices, then even',
    'leetcode' => 328,
    'summary' => 'Reorder by position, not value: odd indices then even, order inside each group unchanged. Two tails plus even-head; weave until the even tail has no next. O(1) extra space. [1,2,3,4,5] → [1,3,5,2,4]. Not Partition List (86).',
    'category' => 'LeetCode',
    'subcategory' => 'Linked List',
    'topic' => 'LeetCode · Linked List',
    'kind' => 'algo',
    'tags' => ['linked-list', 'two-pointers', 'leetcode'],
    'related_session' => 'odd-even-linked-list',
];
