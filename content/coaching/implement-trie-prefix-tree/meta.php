<?php
declare(strict_types=1);

return [
    'title' => 'Implement Trie: 26 children, isEnd for a full word',
    'leetcode' => 208,
    'summary' => 'Walk a deterministic path: insert creates missing children then marks isEnd. search needs the path and isEnd. startsWith only needs the path. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trie',
    'topic' => 'LeetCode · Trie',
    'tags' => ['trie', 'design', 'strings', 'step-by-step'],
    'related_guide' => 'implement-trie-prefix-tree',
];
