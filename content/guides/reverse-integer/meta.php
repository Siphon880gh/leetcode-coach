<?php
declare(strict_types=1);

return [
    'title' => 'Reverse integer: digits without overflow',
    'leetcode' => 7,
    'summary' => 'Peel digits with x % 10, build ans * 10 + y, and abort to 0 if the next multiply would leave 32-bit range.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'kind' => 'algo',
    'tags' => ['math', 'overflow', 'integers', 'leetcode'],
    'related_session' => 'reverse-integer',
];
