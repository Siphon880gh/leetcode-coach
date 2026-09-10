<?php
declare(strict_types=1);

return [
    'title' => 'Wiggle Sort II: reverse-fill small half then large half',
    'leetcode' => 324,
    'summary' => 'Walk a deterministic path: strict peaks nums[0] < nums[1] > nums[2] < …. Sort a copy. Even slots take the smaller half from the mid downward; odd slots take from the end downward. Equals would collide if you filled forward. Not Wiggle Sort (280). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Sorting',
    'topic' => 'LeetCode · Sorting',
    'tags' => ['sorting', 'greedy', 'arrays', 'step-by-step'],
    'related_guide' => 'wiggle-sort-ii',
];
