<?php
declare(strict_types=1);

return [
    'title' => 'Delete Node in a Linked List: copy next, skip next',
    'leetcode' => 237,
    'summary' => 'Walk a deterministic path: you get the node, not the head, and it is not the tail. Copy node.next.val into node, then set node.next to node.next.next. The given object stays; its value and successor change. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Linked List',
    'topic' => 'LeetCode · Linked List',
    'tags' => ['linked-list', 'in-place', 'step-by-step'],
    'related_guide' => 'delete-node-in-a-linked-list',
];
