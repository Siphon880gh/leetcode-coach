<?php
declare(strict_types=1);

return [
    'title' => 'Minimum Genetic Mutation: BFS one letter at a time',
    'leetcode' => 433,
    'difficulty' => 'Med',
    'summary' => '8-letter genes over A/C/G/T. A mutation flips exactly one position and must land in bank (start may be absent). BFS from start: enqueue a bank word only when Hamming distance is 1. First time you hit endGene is the min steps; empty queue → -1. AACCGGTT → AACCGGTA with that word in bank is 1. Not Word Ladder (127).',
    'category' => 'LeetCode',
    'subcategory' => 'BFS',
    'topic' => 'LeetCode · BFS',
    'kind' => 'algo',
    'tags' => ['bfs', 'strings', 'hash-table', 'leetcode'],
];
