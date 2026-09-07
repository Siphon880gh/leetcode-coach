<?php
declare(strict_types=1);

return [
    'title' => 'Sum Root to Leaf Numbers: decimal paths',
    'leetcode' => 129,
    'summary' => 'DFS with a running value s×10+val. A true leaf returns s. A missing child is 0, so a one-child node is still a prefix. Sum the leaves.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'dfs', 'path-sum', 'leetcode'],
    'related_session' => 'sum-root-to-leaf-numbers',
];
