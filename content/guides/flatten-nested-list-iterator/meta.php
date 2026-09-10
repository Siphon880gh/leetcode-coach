<?php
declare(strict_types=1);

return [
    'title' => 'Flatten Nested List Iterator: DFS flatten or a lazy stack',
    'leetcode' => 341,
    'summary' => 'NestedInteger is an int or a list. Iterator next / hasNext over the flattened integers in order. [[1,1],2,[1,1]] → [1,1,2,1,1]. Doocs Solution 1 DFS-builds a flat array. Twin: stack of NestedInteger; hasNext peels lists until an integer is on top. Not 339 (weighted sum).',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'stack', 'iterator', 'leetcode'],
    'related_session' => 'flatten-nested-list-iterator',
];
