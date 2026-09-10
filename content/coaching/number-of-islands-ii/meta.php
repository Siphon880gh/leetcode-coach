<?php
declare(strict_types=1);

return [
    'title' => 'Number of Islands II: union-find as you add land',
    'leetcode' => 305,
    'summary' => 'Walk a deterministic path: empty water grid. Each addLand starts a new island, then unions 4-neighbors already land and drops the count on a real merge. Duplicate cells keep the current count. Not a flood fill after every op. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Union Find',
    'topic' => 'LeetCode · Union Find',
    'tags' => ['union-find', 'graphs', 'matrix', 'step-by-step'],
    'related_guide' => 'number-of-islands-ii',
];
