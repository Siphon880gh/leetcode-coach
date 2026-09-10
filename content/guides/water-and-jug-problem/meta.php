<?php
declare(strict_types=1);

return [
    'title' => 'Water and Jug Problem: target is a multiple of gcd',
    'leetcode' => 365,
    'summary' => 'Jugs of x and y liters, infinite supply. Fill, empty, or pour until full/empty. True iff some state has total (or one jug) equal to target. Bézout: target ≤ x+y and target is a multiple of gcd(x, y) (target 0 is true). 3,5,4 → true. 2,6,5 → false. 1,2,3 → true. DFS on (i, j) is the same search. Not a greedy fill of the larger jug only.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'kind' => 'algo',
    'tags' => ['math', 'gcd', 'bfs', 'dfs', 'leetcode'],
    'related_session' => 'water-and-jug-problem',
];
