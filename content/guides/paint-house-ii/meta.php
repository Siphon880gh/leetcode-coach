<?php
declare(strict_types=1);

return [
    'title' => 'Paint House II: k colors; next takes min of the other colors',
    'leetcode' => 265,
    'summary' => 'n houses, k colors, neighbors must differ. Rolling array of k totals. Paint house i color j by adding costs[i][j] to the min previous total among colors other than j. Answer is min of the k. Follow-up: first and second min of the previous row, O(n k).',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'arrays', 'leetcode'],
    'related_session' => 'paint-house-ii',
];
