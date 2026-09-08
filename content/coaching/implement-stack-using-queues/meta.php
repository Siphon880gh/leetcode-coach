<?php
declare(strict_types=1);

return [
    'title' => 'Implement Stack using Queues: newest sits at the front',
    'leetcode' => 225,
    'summary' => 'Walk a deterministic path: LIFO using only FIFO ops. On push, enqueue x then rotate the older values behind it so the queue front is the stack top. pop/top/empty are then the queue front. One queue is enough. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Queue',
    'topic' => 'LeetCode · Queue',
    'tags' => ['queue', 'stack', 'design', 'step-by-step'],
    'related_guide' => 'implement-stack-using-queues',
];
