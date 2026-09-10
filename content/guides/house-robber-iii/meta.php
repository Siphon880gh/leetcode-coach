<?php
declare(strict_types=1);

return [
    'title' => 'House Robber III: pair of rob / skip at each node',
    'leetcode' => 337,
    'summary' => 'Binary tree of houses. Adjacent (parent–child) cannot both be robbed. Post-order: (take this node plus skip on both children, skip this node plus the better choice on each child). Answer is the max of the two at the root. [3,2,3,null,3,null,1] → 7. Not 198’s linear scan.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'trees', 'dfs', 'leetcode'],
    'related_session' => 'house-robber-iii',
];
