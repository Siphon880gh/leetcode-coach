<?php
declare(strict_types=1);

return [
    'title' => 'Flatten Nested List Iterator: DFS flatten or a lazy stack',
    'leetcode' => 341,
    'summary' => 'Walk a deterministic path: NestedInteger is an int or a list. Iterator next / hasNext over the flattened integers in order. [[1,1],2,[1,1]] → [1,1,2,1,1]. DFS-build a flat array, or a stack that peels lists until an integer is on top. Not 339 (weighted sum). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'stack', 'iterator', 'step-by-step'],
    'related_guide' => 'flatten-nested-list-iterator',
];
