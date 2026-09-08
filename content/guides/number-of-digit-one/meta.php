<?php
declare(strict_types=1);

return [
    'title' => 'Number of Digit One: digit DP, count 1s from 0 to n',
    'leetcode' => 233,
    'summary' => 'n up to 10⁹: you cannot scan every integer. Walk digits of n left to right. dfs(i, cnt, limit) sums how many 1s appear. At a 1, bump cnt. When the prefix is already below n, memoize (i, cnt).',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'digit-dp', 'math', 'leetcode'],
];
