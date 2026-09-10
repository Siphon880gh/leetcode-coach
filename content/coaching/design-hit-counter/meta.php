<?php
declare(strict_types=1);

return [
    'title' => 'Design Hit Counter: hits in the last 300 seconds',
    'leetcode' => 362,
    'summary' => 'Walk a deterministic path: hit(t) records a hit. getHits(t) counts timestamps ≥ t−299. Append t and lower-bound search (or a deque that drops ts ≤ t−300). hit 1,2,3 then getHits(4)=3; hit 300 then getHits(300)=4 and getHits(301)=3. Not 359. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'queue', 'binary-search', 'data-stream', 'step-by-step'],
    'related_guide' => 'design-hit-counter',
];
