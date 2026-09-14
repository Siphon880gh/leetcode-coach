<?php
declare(strict_types=1);

return [
    'title' => 'Construct Quad Tree: leaf if uniform, else four quadrants',
    'leetcode' => 427,
    'difficulty' => 'Med',
    'summary' => 'n by n grid of 0/1, n is a power of two. If a rectangle is all 0 or all 1, emit a leaf. Else emit an internal node and recurse on the four halves. [[0,1],[1,0]] → four leaves under a mixed root. val on a non-leaf may be anything. Not 558 (intersect two trees).',
    'category' => 'LeetCode',
    'subcategory' => 'Divide and Conquer',
    'topic' => 'LeetCode · Divide and Conquer',
    'kind' => 'algo',
    'tags' => ['divide-and-conquer', 'trees', 'matrix', 'leetcode'],
];
