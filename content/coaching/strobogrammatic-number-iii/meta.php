<?php
declare(strict_types=1);

return [
    'title' => 'Strobogrammatic Number III: generate each length, count those in [low, high]',
    'leetcode' => 248,
    'summary' => 'Walk a deterministic path: reuse II’s dfs for every length from len(low) to len(high), then count strings whose integer value sits in the closed range. Do not scan every integer. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Recursion',
    'topic' => 'LeetCode · Recursion',
    'tags' => ['recursion', 'strings', 'math', 'step-by-step'],
    'related_guide' => 'strobogrammatic-number-iii',
];
