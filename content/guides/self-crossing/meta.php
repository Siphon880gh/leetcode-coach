<?php
declare(strict_types=1);

return [
    'title' => 'Self Crossing: three local patterns on a CCW spiral',
    'leetcode' => 335,
    'summary' => 'Start at (0,0), north then west, south, east, repeating. n up to 1e5 so do not stamp every lattice point. The current edge only meets a recent one: 4th hits 1st, 5th meets 1st, or 6th crosses 1st. [2,1,1,2] true; [1,2,3,4] false.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'kind' => 'algo',
    'tags' => ['math', 'geometry', 'arrays', 'leetcode'],
    'related_session' => 'self-crossing',
];
