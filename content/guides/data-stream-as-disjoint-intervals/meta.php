<?php
declare(strict_types=1);

return [
    'title' => 'Data Stream as Disjoint Intervals: TreeMap merge of neighbors',
    'leetcode' => 352,
    'summary' => 'addNum / getIntervals: keep sorted disjoint [start, end]. Floor and ceiling around val. If val stitches two intervals, merge; else extend one side or insert [val, val]. Duplicates inside a range are no-ops. 1 then 3 then 2 → [[1, 3]]. Not Merge Intervals on a full list each query.',
    'category' => 'LeetCode',
    'subcategory' => 'Ordered Set',
    'topic' => 'LeetCode · Ordered Set',
    'kind' => 'algo',
    'tags' => ['ordered-set', 'tree-map', 'design', 'intervals', 'leetcode'],
    'related_session' => 'data-stream-as-disjoint-intervals',
];
