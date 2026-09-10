<?php
declare(strict_types=1);

return [
    'title' => 'Alien Dictionary: edges from consecutive words, then Kahn',
    'leetcode' => 269,
    'summary' => 'Sorted alien words imply letter order. Compare each adjacent pair; first differing letters give an edge earlier → later. Prefix-of-longer is invalid. Kahn-peel letters that appear; a leftover node means a cycle, return empty.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'topological-sort', 'bfs', 'leetcode'],
    'related_session' => 'alien-dictionary',
];
