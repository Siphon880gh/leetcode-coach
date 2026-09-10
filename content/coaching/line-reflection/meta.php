<?php
declare(strict_types=1);

return [
    'title' => 'Line Reflection: min plus max is the only vertical axis',
    'leetcode' => 356,
    'summary' => 'Walk a deterministic path: a vertical mirror exists iff every (x, y) has partner (minX+maxX−x, y) in the set. [[1,1],[-1,1]] → true. [[1,1],[-1,-1]] → false. Stay in integers; not every pair as an axis. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'tags' => ['hash-table', 'geometry', 'math', 'step-by-step'],
    'related_guide' => 'line-reflection',
];
