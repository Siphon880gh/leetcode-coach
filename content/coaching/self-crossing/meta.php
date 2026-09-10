<?php
declare(strict_types=1);

return [
    'title' => 'Self Crossing: three local patterns on a CCW spiral',
    'leetcode' => 335,
    'summary' => 'Walk a deterministic path: start at (0,0), north then west, south, east, repeating. n up to 1e5 so do not stamp every lattice point. The current edge only meets a recent one: 4th hits 1st, 5th meets 1st, or 6th crosses 1st. [2,1,1,2] true; [1,2,3,4] false. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'geometry', 'arrays', 'step-by-step'],
    'related_guide' => 'self-crossing',
];
