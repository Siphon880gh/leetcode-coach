<?php
declare(strict_types=1);

return [
    'title' => 'Flatten a Multilevel Doubly Linked List: splice child before next, then continue',
    'leetcode' => 430,
    'difficulty' => 'Med',
    'summary' => 'Each node has prev, next, and optional child. Flatten in place so the child list sits after curr and before curr.next. DFS: save next, recurse into child, clear child, then attach the saved next after the child’s tail. [1,2,3,4,5,6,null,null,null,7,8,9,10,null,null,11,12] → [1,2,3,7,8,11,12,9,10,4,5,6]. Not 114.',
    'category' => 'LeetCode',
    'subcategory' => 'Linked List',
    'topic' => 'LeetCode · Linked List',
    'kind' => 'algo',
    'tags' => ['linked-list', 'dfs', 'doubly-linked-list', 'leetcode'],
];
