<?php
declare(strict_types=1);

return [
    'title' => 'Customers Who Never Order: LEFT JOIN, keep NULL orders',
    'leetcode' => 183,
    'summary' => 'Anti-join: left-join Customers to Orders on id = customerId, keep rows where the order side is NULL. NOT IN / NOT EXISTS is the same set.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'kind' => 'algo',
    'tags' => ['database', 'sql', 'join', 'leetcode'],
];
