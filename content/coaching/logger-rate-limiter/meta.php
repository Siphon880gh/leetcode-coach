<?php
declare(strict_types=1);

return [
    'title' => 'Logger Rate Limiter: next-allowed timestamp per message',
    'leetcode' => 359,
    'summary' => 'Walk a deterministic path: map each message to the next allowed timestamp (unseen is 0). Print if t is at least that, then store t+10. foo at 1 then 11 is true; 10 is still blocked. Not one global cooldown. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'hash-map', 'data-stream', 'step-by-step'],
    'related_guide' => 'logger-rate-limiter',
];
