<?php
declare(strict_types=1);

return [
    'title' => 'Flatten 2D Vector: skip empty rows with two indices',
    'leetcode' => 251,
    'summary' => 'Iterator over vec[i][j] without copying into one list. Keep a row i and column j. Before next or hasNext, advance while the current inner list is exhausted. Empty inner lists are legal.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'two-pointers', 'iterator', 'leetcode'],
    'related_session' => 'flatten-2d-vector',
];
