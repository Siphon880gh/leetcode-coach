<?php
declare(strict_types=1);

return [
    'title' => 'Expression Add Operators: DFS operands; times undoes the last addend',
    'leetcode' => 282,
    'summary' => 'Insert plus, minus, or times between digits so the expression equals target. No leading zeros. Track the last operand: times replaces it with last times next (curr minus last plus that product). “123” to 6 is 1×2×3 and 1+2+3.',
    'category' => 'LeetCode',
    'subcategory' => 'Backtracking',
    'topic' => 'LeetCode · Backtracking',
    'kind' => 'algo',
    'tags' => ['backtracking', 'math', 'strings', 'leetcode'],
    'related_session' => 'expression-add-operators',
];
