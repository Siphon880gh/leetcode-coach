<?php
declare(strict_types=1);

return [
    'title' => 'Maximum XOR of Two Numbers: binary trie, prefer the opposite bit',
    'leetcode' => 421,
    'difficulty' => 'Med',
    'summary' => 'Max nums[i] XOR nums[j] (i may equal j). n is 2e5 so do not pair every pair. Insert 31 bits (30..0) into a 0/1 trie. Query x by always walking the opposite bit when it exists. [3,10,5,25,2,8] → 28 (5 XOR 25). Not 136 (single number). Not 421 vs pairwise O(n²).',
    'category' => 'LeetCode',
    'subcategory' => 'Trie',
    'topic' => 'LeetCode · Trie',
    'kind' => 'algo',
    'tags' => ['trie', 'bit-manipulation', 'hash-table', 'leetcode'],
];
