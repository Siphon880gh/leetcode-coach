<?php
declare(strict_types=1);

return [
    'title' => 'Delete Duplicate Emails: keep the smallest id per email',
    'leetcode' => 196,
    'summary' => 'DELETE extras, not a SELECT. For each email keep the row with min id. Self-join delete where same email and a larger id. Duplicate Emails only listed the repeats.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'kind' => 'algo',
    'tags' => ['database', 'sql', 'delete', 'leetcode'],
    'related_session' => 'delete-duplicate-emails',
];
