<?php
declare(strict_types=1);

return [
    'title' => 'Design Snake Game: deque body, drop tail before self-check',
    'leetcode' => 353,
    'summary' => 'Walk a deterministic path: deque of body cells plus a set. On a non-food move, pop the tail first, then die on a wall or the remaining body. Food appears one piece at a time. 3×2 with food (1,2) then (0,1): R, D, R, U, L, U → 0, 0, 1, 1, 2, −1. Not a full board. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'queue', 'simulation', 'hash-set', 'step-by-step'],
    'related_guide' => 'design-snake-game',
];
