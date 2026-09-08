<?php
declare(strict_types=1);

return [
    'title' => 'Basic Calculator: stack the outer ans and sign at each paren',
    'leetcode' => 224,
    'summary' => 'Walk a deterministic path: plus, minus, parentheses, spaces. Keep running ans and a sign. On an open paren, push ans and sign then reset. On close, ans = popped sign times inner ans plus popped outer ans. No eval. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'tags' => ['stack', 'math', 'string', 'step-by-step'],
    'related_guide' => 'basic-calculator',
];
