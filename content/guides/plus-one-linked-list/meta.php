<?php
declare(strict_types=1);

return [
    'title' => 'Plus One Linked List: last non-nine, then zero the tail',
    'leetcode' => 369,
    'summary' => 'Digits MSD at the head. Dummy 0 in front. Remember the last node that is not 9, add 1 there, set every node after it to 0. If dummy becomes 1, the number was all nines — return dummy. [1,2,3] → [1,2,4]. Not 66 (array). Not 2 (reversed lists).',
    'category' => 'LeetCode',
    'subcategory' => 'Linked List',
    'topic' => 'LeetCode · Linked List',
    'kind' => 'algo',
    'tags' => ['linked-list', 'math', 'carry', 'leetcode'],
    'related_session' => 'plus-one-linked-list',
];
