<?php
declare(strict_types=1);

return [
    'title' => 'Meeting Rooms: sort by start; a later start must be after the previous end',
    'leetcode' => 252,
    'summary' => 'One person can attend all meetings iff none overlap. Sort by start time. For each consecutive pair, previous end must be ≤ next start. Touching at time t is allowed. Empty is true.',
    'category' => 'LeetCode',
    'subcategory' => 'Sorting',
    'topic' => 'LeetCode · Sorting',
    'kind' => 'algo',
    'tags' => ['sorting', 'intervals', 'arrays', 'leetcode'],
    'related_session' => 'meeting-rooms',
];
