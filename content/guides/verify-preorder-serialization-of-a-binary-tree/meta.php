<?php
declare(strict_types=1);

return [
    'title' => 'Verify Preorder Serialization of a Binary Tree: collapse leaves on a stack',
    'leetcode' => 331,
    'summary' => 'Comma-separated preorder with # for null. Do not rebuild the tree. Push tokens; whenever value, #, # sit on top, replace them with one #. Valid iff the stack ends as a single #. “9,3,4,#,#,1,#,#,2,#,6,#,#” is true; “1,#” is false.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'kind' => 'algo',
    'tags' => ['stack', 'binary-tree', 'strings', 'leetcode'],
    'related_session' => 'verify-preorder-serialization-of-a-binary-tree',
];
