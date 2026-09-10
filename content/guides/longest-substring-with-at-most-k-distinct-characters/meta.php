<?php
declare(strict_types=1);

return [
    'title' => 'Longest Substring with At Most K Distinct Characters: shrink when the map exceeds k',
    'leetcode' => 340,
    'summary' => 'Longest substring with at most k different letters. Expand right; while the frequency map has more than k keys, drop s[left] and advance left. Record right − left + 1. “eceba”, k=2 → 3 (“ece”). k=0 → 0. 159 is this with k fixed at 2.',
    'category' => 'LeetCode',
    'subcategory' => 'Sliding Window',
    'topic' => 'LeetCode · Sliding Window',
    'kind' => 'algo',
    'tags' => ['sliding-window', 'hash-table', 'strings', 'leetcode'],
    'related_session' => 'longest-substring-with-at-most-k-distinct-characters',
];
