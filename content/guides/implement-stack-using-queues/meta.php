<?php
declare(strict_types=1);

return [
    'title' => 'Implement Stack using Queues: newest sits at the front',
    'leetcode' => 225,
    'summary' => 'LIFO using only FIFO ops. On push, enqueue x then rotate the older values behind it so the queue front is the stack top. pop/top/empty are then the queue front. One queue is enough.',
    'category' => 'LeetCode',
    'subcategory' => 'Queue',
    'topic' => 'LeetCode · Queue',
    'kind' => 'algo',
    'tags' => ['queue', 'stack', 'design', 'leetcode'],
    'related_session' => 'implement-stack-using-queues',
];
