<?php
declare(strict_types=1);

return [
    'title' => 'Logger Rate Limiter: next-allowed timestamp per message',
    'leetcode' => 359,
    'summary' => 'shouldPrintMessage(t, msg): same message at most once per 10 seconds. Map each message to the next allowed t. Print if t is at least that (unseen defaults to 0), then store t+10. foo at 1 then 11 is true; 10 is still blocked. Chronological. Not one global cooldown.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'hash-map', 'data-stream', 'leetcode'],
    'related_session' => 'logger-rate-limiter',
];
