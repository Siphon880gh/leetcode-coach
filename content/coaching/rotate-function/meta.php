<?php
declare(strict_types=1);

return [
    'title' => 'Rotate Function: next F from last F plus sum minus n times the new head',
    'leetcode' => 396,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: F(k) is the weighted sum after a clockwise rotate by k. Next F = last F + sum(nums) − n times the value that just became index 0. [4,3,2,6] → 26. [100] → 0. Do not rebuild each F from scratch. Not 189. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'arrays', 'dynamic-programming', 'step-by-step'],
    'related_guide' => 'rotate-function',
];
