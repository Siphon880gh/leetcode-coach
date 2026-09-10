<?php
declare(strict_types=1);

return [
    'title' => 'Rearrange String k Distance Apart: greedy max-heap plus cooldown',
    'leetcode' => 358,
    'summary' => 'Rewrite s so identical letters are at least k apart, or return empty. Always place the letter with the most remaining copies; park it in a cooldown queue of length k before it can be used again. If the heap empties before s is rebuilt, impossible. aabbcc, k=3 → abcabc. 767 is the k=2 case.',
    'category' => 'LeetCode',
    'subcategory' => 'Greedy',
    'topic' => 'LeetCode · Greedy',
    'kind' => 'algo',
    'tags' => ['greedy', 'heap', 'strings', 'leetcode'],
    'related_session' => 'rearrange-string-k-distance-apart',
];
