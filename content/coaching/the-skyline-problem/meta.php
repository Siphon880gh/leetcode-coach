<?php
declare(strict_types=1);

return [
    'title' => 'The Skyline Problem: sweep x, emit when max height changes',
    'leetcode' => 218,
    'summary' => 'Walk a deterministic path: sort every left and right x. At each x, push buildings that start, drop those that ended, then take the live max height. Append [x, h] only when h differs from the last key point. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Sweep Line',
    'topic' => 'LeetCode · Sweep Line',
    'tags' => ['sweep-line', 'heap', 'sorting', 'step-by-step'],
    'related_guide' => 'the-skyline-problem',
];
