<?php
declare(strict_types=1);

return [
    'title' => 'Duplicate Emails: GROUP BY email, HAVING count greater than 1',
    'leetcode' => 182,
    'summary' => 'Group Person by email. Keep groups with more than one row. Self-join on same email and different id is the same idea, then DISTINCT.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'kind' => 'algo',
    'tags' => ['database', 'sql', 'leetcode'],
    'related_session' => 'duplicate-emails',
];
