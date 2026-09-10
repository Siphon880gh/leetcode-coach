<?php
declare(strict_types=1);

return [
    'title' => 'Sort Transformed Array: two pointers on a parabola',
    'leetcode' => 360,
    'summary' => 'nums is already sorted. Transform each x to a × x² + b × x + c and return that sequence sorted. When a > 0 the parabola opens up: ends are largest, so fill the answer from the back with the larger of f(left) and f(right). When a ≤ 0 fill from the front with the smaller end. a = 0 (linear) uses the fill-front rule. Do not map then sort.',
    'category' => 'LeetCode',
    'subcategory' => 'Two Pointers',
    'topic' => 'LeetCode · Two Pointers',
    'kind' => 'algo',
    'tags' => ['two-pointers', 'math', 'arrays', 'sorting', 'leetcode'],
    'related_session' => 'sort-transformed-array',
];
