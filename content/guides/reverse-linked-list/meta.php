<?php
declare(strict_types=1);

return [
    'title' => 'Reverse Linked List: peel the front onto a dummy',
    'leetcode' => 206,
    'summary' => 'Head insertion: save next, point curr at dummy.next, hang curr on dummy, advance. Return dummy.next. Recursion flips from the tail. Empty list stays empty.',
    'category' => 'LeetCode',
    'subcategory' => 'Linked List',
    'topic' => 'LeetCode · Linked List',
    'kind' => 'algo',
    'tags' => ['linked-list', 'reverse', 'recursion', 'leetcode'],
    'related_session' => 'reverse-linked-list',
];
