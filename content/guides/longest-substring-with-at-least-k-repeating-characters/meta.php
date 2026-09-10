<?php
declare(strict_types=1);

return [
    'title' => 'Longest Substring with At Least K Repeating: split on rare letters',
    'leetcode' => 395,
    'difficulty' => 'Med',
    'summary' => 'Longest substring where every letter appears at least k times. Count the segment; any letter with count < k is a wall — recurse on the pieces between those walls. aaabb, k=3 → 3. ababbc, k=2 → 5. Not 340 (at most k distinct). Not 3 (no repeats).',
    'category' => 'LeetCode',
    'subcategory' => 'Divide and Conquer',
    'topic' => 'LeetCode · Divide and Conquer',
    'kind' => 'algo',
    'tags' => ['divide-and-conquer', 'sliding-window', 'strings', 'leetcode'],
];
