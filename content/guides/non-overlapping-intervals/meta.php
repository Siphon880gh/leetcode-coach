<?php
declare(strict_types=1);

return [
    'title' => 'Non-overlapping Intervals: sort by end, keep the earliest finish',
    'leetcode' => 435,
    'difficulty' => 'Med',
    'summary' => 'Min removals so remaining intervals do not overlap. Sort by right end; greedily keep an interval if its start is at least the last kept end (touching at a point is allowed). Removals = n minus how many you kept. [[1,2],[2,3],[3,4],[1,3]] → 1. Not Merge Intervals (56).',
    'category' => 'LeetCode',
    'subcategory' => 'Greedy',
    'topic' => 'LeetCode · Greedy',
    'kind' => 'algo',
    'tags' => ['greedy', 'sorting', 'intervals', 'leetcode'],
];
