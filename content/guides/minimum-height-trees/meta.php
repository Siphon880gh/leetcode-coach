<?php
declare(strict_types=1);

return [
    'title' => 'Minimum Height Trees: peel leaves until one or two centroids remain',
    'leetcode' => 310,
    'summary' => 'n nodes, n−1 undirected edges. Roots that minimize height are the tree’s center: 1 node if odd diameter, 2 if even. BFS from all degree-1 leaves inward; the last remaining layer is the answer. n=1 → [0]. Not DFS height from every node.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'trees', 'bfs', 'topological-sort', 'leetcode'],
    'related_session' => 'minimum-height-trees',
];
