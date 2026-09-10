<?php
declare(strict_types=1);

return [
    'title' => 'Flip Game: every ++ pair flipped to --',
    'leetcode' => 293,
    'summary' => 'Walk a deterministic path: list every string after one move: two consecutive pluses become minuses. Scan adjacent pairs, flip, record, restore. “++++” has three moves; a lone “+” has none. Not Flip Game II’s win/lose search. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Strings',
    'topic' => 'LeetCode · Strings',
    'tags' => ['strings', 'simulation', 'step-by-step'],
    'related_guide' => 'flip-game',
];
