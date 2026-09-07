<?php
declare(strict_types=1);

return [
    'title' => 'Symmetric tree: left mirrors right',
    'leetcode' => 101,
    'summary' => 'One root. dfs(left, right) crosses children: a.left with b.right, a.right with b.left. Same Tree’s same-side pairing is the wrong check.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'dfs', 'mirror', 'leetcode'],
    'related_session' => 'symmetric-tree',
];
