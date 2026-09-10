<?php
declare(strict_types=1);

return [
    'title' => 'Evaluate Division: weighted union-find along ratios',
    'leetcode' => 399,
    'difficulty' => 'Med',
    'summary' => 'equations[i] is Ai / Bi = values[i]. Answer each Cj / Dj, or −1 if a variable is missing or they sit in different components. Weighted UF: w[x] is x over its parent; compress by multiplying weights. a/b=2, b/c=3 → a/c=6, b/a=0.5, x/x=−1. Graph DFS also works. Not unweighted connectivity.',
    'category' => 'LeetCode',
    'subcategory' => 'Union Find',
    'topic' => 'LeetCode · Union Find',
    'kind' => 'algo',
    'tags' => ['union-find', 'graph', 'dfs', 'leetcode'],
];
