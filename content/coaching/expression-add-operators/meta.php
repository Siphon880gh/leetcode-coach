<?php
declare(strict_types=1);

return [
    'title' => 'Expression Add Operators: DFS operands; times undoes the last addend',
    'leetcode' => 282,
    'summary' => 'Walk a deterministic path: insert plus, minus, or times between digits so the value hits target. No leading zeros. Times undoes the last addend, then multiplies. “123” to 6 is 1×2×3 and 1+2+3. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'tags' => ['backtracking', 'math', 'strings', 'step-by-step'],
    'related_guide' => 'expression-add-operators',
];
