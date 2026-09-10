<?php
declare(strict_types=1);

return [
    'title' => 'Bulls and Cows: matches in place, then leftover digit mins',
    'leetcode' => 299,
    'summary' => 'Bulls are same digit same index. Cows are the rest: for each digit, min of leftover secret count and leftover guess count. Format xAyB. “1123” vs “0111” is 1A1B, not two cows for the extra 1s.',
    'category' => 'LeetCode',
    'subcategory' => 'Hash Table',
    'topic' => 'LeetCode · Hash Table',
    'kind' => 'algo',
    'tags' => ['hash-table', 'strings', 'counting', 'leetcode'],
    'related_session' => 'bulls-and-cows',
];
