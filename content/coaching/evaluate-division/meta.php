<?php
declare(strict_types=1);

return [
    'title' => 'Evaluate Division: weighted union-find along ratios',
    'leetcode' => 399,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: equations[i] is Ai / Bi = values[i]. Answer each Cj / Dj, or −1 if a variable is missing or they sit in different components. Weighted UF: w[x] is x over its parent; compress by multiplying weights. a/b=2, b/c=3 → a/c=6. x/x=−1. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Union Find',
    'topic' => 'LeetCode · Union Find',
    'tags' => ['union-find', 'graph', 'dfs', 'step-by-step'],
    'related_guide' => 'evaluate-division',
];
