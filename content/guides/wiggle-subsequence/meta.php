<?php
declare(strict_types=1);

return [
    'title' => 'Wiggle Subsequence: up/down DP, then one-pass peaks',
    'leetcode' => 376,
    'summary' => 'Longest subsequence whose successive diffs strictly alternate sign. f[i] ends on an up, g[i] on a down. Equals never extend. [1,7,4,9,2,5] → 6; a rising run → 2. Follow-up: keep two running lengths in O(n). Not 280 (reorder in place).',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'greedy', 'arrays', 'leetcode'],
    'related_session' => 'wiggle-subsequence',
];
