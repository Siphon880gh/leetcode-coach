<?php
declare(strict_types=1);

return [
    'title' => 'Alien Dictionary: edges from consecutive words, then Kahn',
    'leetcode' => 269,
    'summary' => 'Walk a deterministic path: adjacent word pairs; first differing letters give earlier → later; prefix-of-longer is invalid; Kahn-peel letters that appear. Leftover node or reverse edge → empty. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'tags' => ['graphs', 'topological-sort', 'bfs', 'step-by-step'],
    'related_guide' => 'alien-dictionary',
];
