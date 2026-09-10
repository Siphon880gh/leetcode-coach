<?php
declare(strict_types=1);

return [
    'title' => 'Implement Queue using Stacks: pour in to out when out is empty',
    'leetcode' => 232,
    'summary' => 'Walk a deterministic path: FIFO with two stacks. push onto in. pop/peek: if out is empty, pour in into out (reverses order), then use out’s top. empty is both stacks empty. Amortized O(1). Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'tags' => ['stack', 'queue', 'design', 'step-by-step'],
    'related_guide' => 'implement-queue-using-stacks',
];
