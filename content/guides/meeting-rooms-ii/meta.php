<?php
declare(strict_types=1);

return [
    'title' => 'Meeting Rooms II: sweep +1 at start, −1 at end; track the peak',
    'leetcode' => 253,
    'summary' => 'Minimum rooms is max concurrent meetings. Mark +1 at each start and −1 at each end. Scan times in order (or a difference array) and keep the running sum’s peak. A meeting ending at t frees the room for a start at t.',
    'category' => 'LeetCode',
    'subcategory' => 'Sorting',
    'topic' => 'LeetCode · Sorting',
    'kind' => 'algo',
    'tags' => ['sorting', 'heap', 'sweep-line', 'intervals', 'leetcode'],
    'related_session' => 'meeting-rooms-ii',
];
