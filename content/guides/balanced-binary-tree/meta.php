<?php
declare(strict_types=1);

return [
    'title' => 'Balanced tree: height or -1 if a tilt',
    'leetcode' => 110,
    'summary' => 'Bottom-up height. If a child already failed or abs(l-r) > 1, return -1. The boolean is height(root) ≥ 0. Empty is true.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'dfs', 'height', 'leetcode'],
    'related_session' => 'balanced-binary-tree',
];
