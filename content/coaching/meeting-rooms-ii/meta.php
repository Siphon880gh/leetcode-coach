<?php
declare(strict_types=1);

return [
    'title' => 'Meeting Rooms II: sweep +1 at start, −1 at end; track the peak',
    'leetcode' => 253,
    'summary' => 'Walk a deterministic path: minimum rooms is max concurrent. Difference array or map: +1 at start, −1 at end. Prefix-sum peak. An end at t frees a room for a start at t. Not the 252 yes/no. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Sorting',
    'topic' => 'LeetCode · Sorting',
    'tags' => ['sorting', 'heap', 'sweep-line', 'intervals', 'step-by-step'],
    'related_guide' => 'meeting-rooms-ii',
];
