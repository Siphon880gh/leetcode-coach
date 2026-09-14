<?php
declare(strict_types=1);

return [
    'title' => 'Binary Watch: hours and minutes whose bit counts sum to n',
    'leetcode' => 401,
    'difficulty' => 'Easy',
    'summary' => 'Walk a deterministic path: 4 hour LEDs (0–11) and 6 minute LEDs (0–59). Return every time where the 1-bits in the hour plus the minute equal turnedOn. Format H:MM with no leading hour zero. turnedOn=1 → ten times. turnedOn=9 → empty. Enumerate 12 by 60. Not 191. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'tags' => ['bit-manipulation', 'backtracking', 'step-by-step'],
    'related_guide' => 'binary-watch',
];
