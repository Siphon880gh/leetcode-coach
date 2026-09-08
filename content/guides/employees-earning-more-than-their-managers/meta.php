<?php
declare(strict_types=1);

return [
    'title' => 'Employees Earning More Than Their Managers: self-join on managerId',
    'leetcode' => 181,
    'summary' => 'Join Employee to itself: worker.managerId = boss.id. Keep rows where worker.salary is greater than boss.salary. INNER JOIN drops people with no manager.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'kind' => 'algo',
    'tags' => ['database', 'sql', 'join', 'leetcode'],
    'related_session' => 'employees-earning-more-than-their-managers',
];
