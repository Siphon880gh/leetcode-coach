<?php
declare(strict_types=1);

return [
    'title' => 'Word Ladder II: all shortest ladders',
    'leetcode' => 126,
    'summary' => 'If end is missing, return []. BFS by layers, keep every predecessor at the first distance, stop that layer, then DFS the DAG from the end.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'bfs', 'backtracking', 'leetcode'],
    'related_session' => 'word-ladder-ii',
];
