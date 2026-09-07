<?php
declare(strict_types=1);

return [
    'title' => 'Combine Two Tables: LEFT JOIN so missing addresses stay NULL',
    'leetcode' => 175,
    'summary' => 'Keep every Person. Join Address on personId from the left. No matching row → NULL city and state. INNER JOIN would drop them.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'kind' => 'algo',
    'tags' => ['database', 'sql', 'join', 'leetcode'],
    'related_session' => 'combine-two-tables',
];
