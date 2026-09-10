<?php
declare(strict_types=1);

return [
    'title' => 'Remove Duplicate Letters: greedy stack, pop if it appears later',
    'leetcode' => 316,
    'summary' => 'One of each letter, smallest subsequence. last[c] is the last index of c. Skip if already in the stack. While the top is > c and that letter still appears later, pop it. “bcabc” → “abc”; “cbacdcbc” → “acdb”. Same as 1081.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'kind' => 'algo',
    'tags' => ['stack', 'greedy', 'monotonic-stack', 'leetcode'],
    'related_session' => 'remove-duplicate-letters',
];
