<?php
declare(strict_types=1);

return [
    'title' => 'Find Leaves of Binary Tree: group by height from the leaves',
    'leetcode' => 366,
    'summary' => 'Collect all current leaves, remove them, repeat until the tree is empty. That is height-from-leaves: a leaf is 0, a parent is 1 + max of its children. Append val into ans[h]. [1,2,3,4,5] → [[4,5,3],[2],[1]] (order inside a wave does not matter). Not root-to-leaf level order. Not repeated O(n) scans that strip leaves.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'dfs', 'binary-tree', 'leetcode'],
    'related_session' => 'find-leaves-of-binary-tree',
];
