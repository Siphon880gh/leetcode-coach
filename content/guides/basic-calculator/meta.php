<?php
declare(strict_types=1);

return [
    'title' => 'Basic Calculator: stack the outer ans and sign at each paren',
    'leetcode' => 224,
    'summary' => 'Plus, minus, parentheses, spaces. Keep running ans and a sign. On an open paren, push ans and sign then reset. On close, ans = popped sign times inner ans plus popped outer ans. No eval.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'kind' => 'algo',
    'tags' => ['stack', 'math', 'string', 'leetcode'],
    'related_session' => 'basic-calculator',
];
