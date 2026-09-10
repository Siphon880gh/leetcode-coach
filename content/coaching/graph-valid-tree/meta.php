<?php
declare(strict_types=1);

return [
    'title' => 'Graph Valid Tree: no cycle and one component',
    'leetcode' => 261,
    'summary' => 'Walk a deterministic path: union-find. If an edge joins two nodes already in the same set, there is a cycle. Else merge and drop a component. True iff you finish with exactly one component. DFS twin needs n−1 edges. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'tags' => ['graphs', 'union-find', 'dfs', 'step-by-step'],
    'related_guide' => 'graph-valid-tree',
];
