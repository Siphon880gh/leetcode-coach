<?php
declare(strict_types=1);

return [
    'title' => 'Summary Ranges: grow while the next value is plus one',
    'leetcode' => 228,
    'summary' => 'Walk a deterministic path: sorted unique nums. From each start, walk while nums[j+1] equals nums[j] plus 1. Emit "a" if the run is one value, else "a->b". Empty input is an empty list. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'tags' => ['arrays', 'two-pointers', 'intervals', 'step-by-step'],
    'related_guide' => 'summary-ranges',
];
