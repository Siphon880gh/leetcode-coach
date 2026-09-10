<?php
declare(strict_types=1);

return [
    'title' => 'Graph Valid Tree: no cycle and one component',
    'leetcode' => 261,
    'summary' => 'Undirected graph on n nodes. Union-find: if an edge joins two nodes already in the same set, there is a cycle. Else merge and drop a component. True iff you finish with exactly one component (a tree has n−1 edges).',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'union-find', 'dfs', 'leetcode'],
    'related_session' => 'graph-valid-tree',
];
