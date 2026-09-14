<?php
declare(strict_types=1);

return [
    'title' => 'Remove K Digits: monotonic stack, drop left peaks',
    'leetcode' => 402,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: delete k digits so the leftover integer is smallest. Walk left to right; while the stack top is larger than the next digit and you still have removals, pop that peak. Keep the first n−k digits, strip leading zeros. 1432219 and k=3 → 1219. 10 and k=2 → 0. Not 316. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'tags' => ['stack', 'greedy', 'monotonic-stack', 'step-by-step'],
    'related_guide' => 'remove-k-digits',
];
