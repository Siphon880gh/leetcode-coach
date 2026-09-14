<?php
declare(strict_types=1);

return [
    'title' => 'Remove K Digits: monotonic stack, drop left peaks',
    'leetcode' => 402,
    'difficulty' => 'Med',
    'summary' => 'Delete k digits so the leftover integer is smallest. Walk left to right; while the stack top is larger than the next digit and you still have removals, pop that peak. Keep the first n−k digits, strip leading zeros. 1432219 and k=3 → 1219. 10200 and k=1 → 200. 10 and k=2 → 0. Not 316. Not 321.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'kind' => 'algo',
    'tags' => ['stack', 'greedy', 'monotonic-stack', 'leetcode'],
    'related_session' => 'remove-k-digits',
];
