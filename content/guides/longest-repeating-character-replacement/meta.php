<?php
declare(strict_types=1);

return [
    'title' => 'Longest Repeating Character Replacement: window minus majority ≤ k',
    'leetcode' => 424,
    'difficulty' => 'Med',
    'summary' => 'At most k replacements to any uppercase letter. Longest substring that can become all the same letter. Sliding window: length minus the majority count in the window must stay ≤ k. "ABAB", k=2 → 4. "AABABBA", k=1 → 4. Not 3 (no repeats). Not 340 (at most k distinct).',
    'category' => 'LeetCode',
    'subcategory' => 'Sliding Window',
    'topic' => 'LeetCode · Sliding Window',
    'kind' => 'algo',
    'tags' => ['sliding-window', 'strings', 'hash-table', 'leetcode'],
];
