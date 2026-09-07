<?php
declare(strict_types=1);

return [
    'title' => 'Insertion Sort List: splice each node into the sorted prefix',
    'leetcode' => 147,
    'summary' => 'Dummy sentinel. Walk cur; if out of order, unlink it and splice into the sorted prefix by value. Return dummy.next. O(n²).',
    'category' => 'LeetCode',
    'subcategory' => 'Linked List',
    'topic' => 'LeetCode · Linked List',
    'kind' => 'algo',
    'tags' => ['linked-list', 'sorting', 'dummy', 'leetcode'],
    'related_session' => 'insertion-sort-list',
];
