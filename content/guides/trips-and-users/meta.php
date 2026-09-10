<?php
declare(strict_types=1);

return [
    'title' => 'Trips and Users: unbanned both sides, daily cancel rate',
    'leetcode' => 262,
    'summary' => 'Keep trips where client and driver are both banned = No. Restrict to 2013-10-01..03. Group by day. Cancellation rate is the average of (status is not completed), rounded to two decimals.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'kind' => 'algo',
    'tags' => ['database', 'sql', 'join', 'leetcode'],
    'related_session' => 'trips-and-users',
];
