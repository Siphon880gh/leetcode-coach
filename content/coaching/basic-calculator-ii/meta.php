<?php
declare(strict_types=1);

return [
    'title' => 'Basic Calculator II: stack plus/minus terms; fold times and divide now',
    'leetcode' => 227,
    'summary' => 'Walk a deterministic path: no parentheses. Parse each number under the previous operator. Plus/minus push the signed value. Times/divide replace the stack top immediately. Sum the stack. Toward-zero divide. No eval. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'tags' => ['stack', 'math', 'string', 'step-by-step'],
    'related_guide' => 'basic-calculator-ii',
];
