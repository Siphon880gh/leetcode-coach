<?php
declare(strict_types=1);

return [
    'title' => 'Bomb Enemy: four ray prefixes, reset at walls',
    'leetcode' => 361,
    'summary' => 'Place one bomb on an empty 0. It kills every E on the same row and column until a W. Precompute kill[i][j] as enemies visible left + right + up + down, resetting the running count at each wall. Answer is the max kill on a 0 (0 if none). Example kills 3. Do not rescan four rays from every empty cell.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'matrix', 'prefix', 'leetcode'],
    'related_session' => 'bomb-enemy',
];
