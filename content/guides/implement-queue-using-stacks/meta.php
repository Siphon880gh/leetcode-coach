<?php
declare(strict_types=1);

return [
    'title' => 'Implement Queue using Stacks: pour in to out when out is empty',
    'leetcode' => 232,
    'summary' => 'FIFO with two stacks. push onto in. pop/peek: if out is empty, pour in into out (reverses order), then use out’s top. empty is both stacks empty. Amortized O(1).',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'kind' => 'algo',
    'tags' => ['stack', 'queue', 'design', 'leetcode'],
    'related_session' => 'implement-queue-using-stacks',
];
