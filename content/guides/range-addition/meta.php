<?php
declare(strict_types=1);

return [
    'title' => 'Range Addition: difference array, then prefix',
    'leetcode' => 370,
    'summary' => 'Zero array of length n. Each update adds inc on an inclusive [start, end]. Write +inc at start and −inc at end+1, then prefix-sum. length 5: [1,3,2], [2,4,3], [0,2,−2] → [−2,0,3,5,3]. Do not loop every cell of every range.',
    'category' => 'LeetCode',
    'subcategory' => 'Prefix Sum',
    'topic' => 'LeetCode · Prefix Sum',
    'kind' => 'algo',
    'tags' => ['prefix-sum', 'difference-array', 'arrays', 'leetcode'],
    'related_session' => 'range-addition',
];
