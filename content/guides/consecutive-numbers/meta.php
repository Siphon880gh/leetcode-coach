<?php
declare(strict_types=1);

return [
    'title' => 'Consecutive Numbers: three equal nums on adjacent ids',
    'leetcode' => 180,
    'summary' => 'Find nums that appear on at least three consecutive ids. Self-join id and id+1 twice, or LAG/LEAD of num ORDER BY id. DISTINCT — a run of four would otherwise repeat.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'kind' => 'algo',
    'tags' => ['database', 'sql', 'window-function', 'leetcode'],
    'related_session' => 'consecutive-numbers',
];
