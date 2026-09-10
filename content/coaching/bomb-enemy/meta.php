<?php
declare(strict_types=1);

return [
    'title' => 'Bomb Enemy: four ray prefixes, reset at walls',
    'leetcode' => 361,
    'summary' => 'Walk a deterministic path: place one bomb on an empty 0. It kills every E on the same row and column until a W. Precompute kill as enemies visible left + right + up + down, resetting at walls. Max on a 0 (0 if none). Example kills 3. Do not rescan four rays from every empty cell. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'matrix', 'prefix', 'step-by-step'],
    'related_guide' => 'bomb-enemy',
];
