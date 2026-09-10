<?php
declare(strict_types=1);

return [
    'title' => 'Longest Substring with At Most K Distinct Characters: shrink when the map exceeds k',
    'leetcode' => 340,
    'summary' => 'Walk a deterministic path: longest substring with at most k different letters. Expand right; while the frequency map has more than k keys, drop s[left] and advance left. Record right − left + 1. eceba, k=2 → 3 (ece). k=0 → 0. 159 is this with k fixed at 2. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Sliding Window',
    'topic' => 'LeetCode · Sliding Window',
    'tags' => ['sliding-window', 'hash-table', 'strings', 'step-by-step'],
    'related_guide' => 'longest-substring-with-at-most-k-distinct-characters',
];
