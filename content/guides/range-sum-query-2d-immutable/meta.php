<?php
declare(strict_types=1);

return [
    'title' => 'Range Sum Query 2D - Immutable: pad prefix, include-exclude',
    'leetcode' => 304,
    'summary' => 'Matrix never changes. s[i+1][j+1] is the sum of the rectangle from (0,0) to (i,j). Query (r1,c1)–(r2,c2) is s[r2+1][c2+1] minus the strip above and the strip left, plus the corner you subtracted twice. O(1) per call.',
    'category' => 'LeetCode',
    'subcategory' => 'Prefix Sum',
    'topic' => 'LeetCode · Prefix Sum',
    'kind' => 'algo',
    'tags' => ['prefix-sum', 'matrix', 'design', 'leetcode'],
    'related_session' => 'range-sum-query-2d-immutable',
];
