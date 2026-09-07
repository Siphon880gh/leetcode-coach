<?php
declare(strict_types=1);

return [
    'title' => 'Clone Graph: map old node to new node',
    'leetcode' => 133,
    'summary' => 'Hash map original→clone. DFS creates a node, stores it, then clones neighbors. Register before the neighbor loop so cycles terminate.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'dfs', 'hash-table', 'leetcode'],
    'related_session' => 'clone-graph',
];
