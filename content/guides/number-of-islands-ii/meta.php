<?php
declare(strict_types=1);

return [
    'title' => 'Number of Islands II: union-find as you add land',
    'leetcode' => 305,
    'summary' => 'Empty water grid. Each addLand turns a cell to land. Start a new island, then union 4-neighbors that are already land and drop the count when two islands merge. Duplicate cells keep the current count. Not a full flood fill after every op.',
    'category' => 'LeetCode',
    'subcategory' => 'Union Find',
    'topic' => 'LeetCode · Union Find',
    'kind' => 'algo',
    'tags' => ['union-find', 'graphs', 'matrix', 'leetcode'],
    'related_session' => 'number-of-islands-ii',
];
