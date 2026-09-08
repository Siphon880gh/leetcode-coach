<?php
declare(strict_types=1);

return [
    'title' => 'Majority Element II: at most two Boyer-Moore candidates',
    'leetcode' => 229,
    'summary' => 'Values more than floor(n/3) times: at most two of them. Keep two (candidate, count) pairs, pairing a third distinct value down. Verify counts in a second pass — unlike 169, nothing is guaranteed.',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'kind' => 'algo',
    'tags' => ['arrays', 'boyer-moore', 'voting', 'leetcode'],
];
