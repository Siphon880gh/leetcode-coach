<?php
declare(strict_types=1);

return [
    'title' => 'Dungeon Game: DP backward so HP stays at least 1',
    'leetcode' => 174,
    'summary' => 'dp[i][j] is the min HP needed at this cell. Take min of right and down, subtract this room, clamp to 1. Start from the princess.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'matrix', 'leetcode'],
    'related_session' => 'dungeon-game',
];
