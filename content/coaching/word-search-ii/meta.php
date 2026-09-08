<?php
declare(strict_types=1);

return [
    'title' => 'Word Search II: trie on the board, emit once',
    'leetcode' => 212,
    'summary' => 'Walk a deterministic path: insert every word into a trie. From each cell, DFS along trie children, mark the cell, restore after. When a node holds a word index, append it and clear the index so you emit once. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trie',
    'topic' => 'LeetCode · Trie',
    'tags' => ['trie', 'backtracking', 'matrix', 'step-by-step'],
    'related_guide' => 'word-search-ii',
];
