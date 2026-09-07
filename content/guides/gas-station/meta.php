<?php
declare(strict_types=1);

return [
    'title' => 'Gas Station: unique start, reset tank on empty',
    'leetcode' => 134,
    'summary' => 'One pass: tank += gas[i]-cost[i]. If tank goes negative, the next start is i+1 and tank resets. If total surplus is negative, return -1.',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'kind' => 'algo',
    'tags' => ['arrays', 'greedy', 'circular', 'leetcode'],
    'related_session' => 'gas-station',
];
