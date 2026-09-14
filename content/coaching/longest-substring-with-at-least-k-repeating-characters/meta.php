<?php
declare(strict_types=1);

return [
    'title' => 'Longest Substring with At Least K Repeating: split on rare letters',
    'leetcode' => 395,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: longest substring where every letter appears at least k times. Count the segment; any letter with count < k is a wall — recurse on the pieces between those walls. aaabb, k=3 → 3. ababbc, k=2 → 5. Not 340. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Divide and Conquer',
    'topic' => 'LeetCode · Divide and Conquer',
    'tags' => ['divide-and-conquer', 'sliding-window', 'strings', 'step-by-step'],
    'related_guide' => 'longest-substring-with-at-least-k-repeating-characters',
];
