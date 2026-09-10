<?php
declare(strict_types=1);

return [
    'title' => 'Design Snake Game: deque body, drop tail before self-check',
    'leetcode' => 353,
    'summary' => 'height × width board; snake starts at (0,0). Deque of cells plus a set. On move, if the new head is not the next food, pop the tail first, then die on wall or occupying the remaining body. Food appears one piece at a time. Width and height up to 10^4, so do not allocate a full grid.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'queue', 'simulation', 'hash-set', 'leetcode'],
    'related_session' => 'design-snake-game',
];
