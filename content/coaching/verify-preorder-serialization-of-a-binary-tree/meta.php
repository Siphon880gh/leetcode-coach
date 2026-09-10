<?php
declare(strict_types=1);

return [
    'title' => 'Verify Preorder Serialization of a Binary Tree: collapse leaves on a stack',
    'leetcode' => 331,
    'summary' => 'Walk a deterministic path: comma-separated preorder with # for null. Do not rebuild the tree. Push tokens; whenever value, #, # sit on top, replace them with one #. Valid iff the stack ends as a single #. “9,3,4,#,#,1,#,#,2,#,6,#,#” is true; “1,#” is false. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'tags' => ['stack', 'binary-tree', 'strings', 'step-by-step'],
    'related_guide' => 'verify-preorder-serialization-of-a-binary-tree',
];
