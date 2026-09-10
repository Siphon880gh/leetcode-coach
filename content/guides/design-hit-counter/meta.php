<?php
declare(strict_types=1);

return [
    'title' => 'Design Hit Counter: hits in the last 300 seconds',
    'leetcode' => 362,
    'summary' => 'hit(t) records a hit. getHits(t) counts hits in the past 300 seconds, i.e. timestamps ≥ t−299. Calls arrive in order; several hits may share t. Append t and binary-search the first kept timestamp (or a deque that drops ts ≤ t−300). hit 1,2,3 then getHits(4)=3; hit 300 then getHits(300)=4 and getHits(301)=3. Not 359 (per-message cooldown).',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'queue', 'binary-search', 'data-stream', 'leetcode'],
    'related_session' => 'design-hit-counter',
];
