<?php
declare(strict_types=1);

return [
    'title' => 'Delete Duplicate Emails: keep the smallest id per email',
    'leetcode' => 196,
    'summary' => 'Walk a deterministic path: DELETE extras, keep min id per email. Self-join p1.id < p2.id. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'tags' => ['database', 'sql', 'delete', 'step-by-step'],
    'related_guide' => 'delete-duplicate-emails',
];
