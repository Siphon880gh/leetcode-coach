<?php
declare(strict_types=1);

return [
    'title' => 'Line Reflection: min plus max is the only vertical axis',
    'leetcode' => 356,
    'summary' => 'True iff some vertical line reflects the point set onto itself. Duplicates allowed. The axis must be midway between min x and max x, so each (x, y) needs partner (minX+maxX−x, y) in the set. [[1,1],[-1,1]] → true. [[1,1],[-1,-1]] → false. Not quadratic pairing.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'kind' => 'algo',
    'tags' => ['hash-table', 'geometry', 'math', 'leetcode'],
    'related_session' => 'line-reflection',
];
