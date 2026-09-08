<?php
declare(strict_types=1);

return [
    'title' => 'Remove Linked List Elements: dummy, skip matching next, stay put',
    'leetcode' => 203,
    'summary' => 'Dummy in front of head. While pre.next exists, skip it when the value matches, otherwise walk pre forward. Consecutive matches all drop. Return dummy.next.',
    'category' => 'LeetCode',
    'subcategory' => 'Linked List',
    'topic' => 'LeetCode · Linked List',
    'kind' => 'algo',
    'tags' => ['linked-list', 'dummy-node', 'leetcode'],
    'related_session' => 'remove-linked-list-elements',
];
