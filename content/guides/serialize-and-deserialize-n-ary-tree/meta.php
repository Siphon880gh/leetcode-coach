<?php
declare(strict_types=1);

return [
    'title' => 'Serialize and Deserialize N-ary Tree: BFS children then a # terminator',
    'leetcode' => 428,
    'difficulty' => 'Hard',
    'summary' => 'Any format is fine if round-trip works. BFS: write the root, then for each dequeued node write its children and a # end-marker. Deserialize splits on commas and rebuilds children until #. Empty → empty. Stateless. Not 297 (binary nulls). Not 429 (level order list only).',
    'category' => 'LeetCode',
    'subcategory' => 'Trees',
    'topic' => 'LeetCode · Trees',
    'kind' => 'algo',
    'tags' => ['trees', 'bfs', 'serialization', 'leetcode'],
];
