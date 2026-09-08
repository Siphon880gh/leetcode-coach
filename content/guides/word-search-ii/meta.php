<?php
declare(strict_types=1);

return [
    'title' => 'Word Search II: trie on the board, emit once',
    'leetcode' => 212,
    'summary' => 'Insert every word into a trie. From each cell, DFS along trie children, mark the cell, restore after. When a node holds a word index, append it and clear the index so you emit once.',
    'category' => 'LeetCode',
    'subcategory' => 'Trie',
    'topic' => 'LeetCode · Trie',
    'kind' => 'algo',
    'tags' => ['trie', 'backtracking', 'matrix', 'leetcode'],
    'related_session' => 'word-search-ii',
];
