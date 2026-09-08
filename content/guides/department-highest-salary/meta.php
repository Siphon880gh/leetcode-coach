<?php
declare(strict_types=1);

return [
    'title' => 'Department Highest Salary: group max, keep every tie',
    'leetcode' => 184,
    'summary' => 'Per department, keep every employee whose salary equals MAX(salary). Tuple IN (departmentId, max), or RANK PARTITION BY department ORDER BY salary DESC with rk = 1.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'kind' => 'algo',
    'tags' => ['database', 'sql', 'window-function', 'leetcode'],
    'related_session' => 'department-highest-salary',
];
