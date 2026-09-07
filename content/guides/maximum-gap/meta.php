<?php
declare(strict_types=1);

return [
    'title' => 'Maximum gap: buckets, then adjacent nonempty mins',
    'leetcode' => 164,
    'summary' => 'n under 2 is 0. Bucket width is (max−min)//(n−1). The max successive gap is this min minus the previous nonempty max.',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'kind' => 'algo',
    'tags' => ['arrays', 'bucket-sort', 'pigeonhole', 'leetcode'],
    'related_session' => 'maximum-gap',
];
