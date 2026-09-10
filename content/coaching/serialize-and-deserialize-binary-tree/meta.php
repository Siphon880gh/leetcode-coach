<?php
declare(strict_types=1);

return [
    'title' => 'Serialize and Deserialize Binary Tree: BFS with null sentinels',
    'leetcode' => 297,
    'summary' => 'Walk a deterministic path: level-order encode: write each node value or #, enqueue both children even when null. Decode: split, grow left then right from a queue of live nodes. Empty tree is the empty string. Not Encode and Decode Strings’ list codec. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'tags' => ['trees', 'bfs', 'design', 'step-by-step'],
    'related_guide' => 'serialize-and-deserialize-binary-tree',
];
