<?php
declare(strict_types=1);

return [
    'title' => 'Data Stream as Disjoint Intervals: TreeMap merge of neighbors',
    'leetcode' => 352,
    'summary' => 'Walk a deterministic path: keep sorted disjoint [start, end]. Floor and ceiling around val. If val stitches two intervals, merge; else extend one side or insert [val, val]. 1 then 3 then 2 → [[1, 3]]. Not Merge Intervals on a full list each query. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Ordered Set',
    'topic' => 'LeetCode · Ordered Set',
    'tags' => ['ordered-set', 'tree-map', 'design', 'intervals', 'step-by-step'],
    'related_guide' => 'data-stream-as-disjoint-intervals',
];
