<?php
declare(strict_types=1);

return [
    'title' => 'Rearrange String k Distance Apart: greedy max-heap plus cooldown',
    'leetcode' => 358,
    'summary' => 'Walk a deterministic path: place the letter with the most leftover copies, then park it in a cooldown of length k. Heap empty before s is rebuilt → empty. aabbcc, k = 3 → abcabc. 767 is k = 2. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Greedy',
    'topic' => 'LeetCode · Greedy',
    'tags' => ['greedy', 'heap', 'strings', 'step-by-step'],
    'related_guide' => 'rearrange-string-k-distance-apart',
];
