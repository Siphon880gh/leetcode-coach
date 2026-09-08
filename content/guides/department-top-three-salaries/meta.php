<?php
declare(strict_types=1);

return [
    'title' => 'Department Top Three Salaries: DENSE_RANK at most 3',
    'leetcode' => 185,
    'summary' => 'Per department, keep employees whose salary is among the top three distinct values. DENSE_RANK PARTITION BY departmentId ORDER BY salary DESC, keep rk <= 3. RANK would skip after ties.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'kind' => 'algo',
    'tags' => ['database', 'sql', 'window-function', 'leetcode'],
    'related_session' => 'department-top-three-salaries',
];
