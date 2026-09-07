<?php
declare(strict_types=1);

return [
    'title' => 'Nth Highest Salary: DISTINCT DESC, skip N minus 1',
    'leetcode' => 177,
    'summary' => 'Function of N: Nth distinct salary descending, or NULL if fewer than N unique values. Decrement N then LIMIT 1 OFFSET N; wrap so a missing row is NULL.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'kind' => 'algo',
    'tags' => ['database', 'sql', 'leetcode'],
    'related_session' => 'nth-highest-salary',
];
