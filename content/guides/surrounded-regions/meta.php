<?php
declare(strict_types=1);

return [
    'title' => 'Surrounded Regions: save the border O’s, then flip',
    'leetcode' => 130,
    'summary' => 'DFS from every border O, mark that component. Then leftover O → X and restore the mark to O. Void, in place.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'dfs', 'matrix', 'leetcode'],
    'related_session' => 'surrounded-regions',
];
