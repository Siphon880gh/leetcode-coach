<?php
declare(strict_types=1);

return [
    'title' => 'Trips and Users: unbanned both sides, daily cancel rate',
    'leetcode' => 262,
    'summary' => 'Walk a deterministic path: join Users twice so client and driver are both unbanned, keep 2013-10-01..03, then ROUND(AVG(status is not completed), 2) per day. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'tags' => ['database', 'sql', 'join', 'step-by-step'],
    'related_guide' => 'trips-and-users',
];
