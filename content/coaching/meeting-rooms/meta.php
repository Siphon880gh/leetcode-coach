<?php
declare(strict_types=1);

return [
    'title' => 'Meeting Rooms: sort by start; a later start must be after the previous end',
    'leetcode' => 252,
    'summary' => 'Walk a deterministic path: sort intervals by start. Consecutive pairs: previous end must be ≤ next start. Touching at time t is allowed. Empty is true. Do not count rooms (253). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Sorting',
    'topic' => 'LeetCode · Sorting',
    'tags' => ['sorting', 'intervals', 'arrays', 'step-by-step'],
    'related_guide' => 'meeting-rooms',
];
