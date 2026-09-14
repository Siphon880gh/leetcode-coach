<?php
declare(strict_types=1);

return [
    'title' => 'Valid Word Square: k-th row equals k-th column, including jagged',
    'leetcode' => 422,
    'difficulty' => 'Easy',
    'summary' => 'True iff the k-th row string equals the k-th column string. Rows may differ in length. For every words[i][j], words[j] must exist and be long enough, and words[j][i] must match. ["abcd","bnrt","crm","dt"] → true. ["ball","area","read","lady"] → false (read vs lead). Not 425 (build squares).',
    'category' => 'LeetCode',
    'subcategory' => 'Matrix',
    'topic' => 'LeetCode · Matrix',
    'kind' => 'algo',
    'tags' => ['matrix', 'arrays', 'strings', 'leetcode'],
];
