<?php
declare(strict_types=1);

return [
    'title' => 'Paint House II: k colors; next takes min of the other colors',
    'leetcode' => 265,
    'summary' => 'Walk a deterministic path: rolling k totals; paint house i color j by adding costs[i][j] to the min previous total among colors other than j. Follow-up: first and second min, O(n k). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'arrays', 'step-by-step'],
    'related_guide' => 'paint-house-ii',
];
