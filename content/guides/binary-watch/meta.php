<?php
declare(strict_types=1);

return [
    'title' => 'Binary Watch: hours and minutes whose bit counts sum to n',
    'leetcode' => 401,
    'difficulty' => 'Easy',
    'summary' => '4 hour LEDs (0–11) and 6 minute LEDs (0–59). Return every time where the number of 1-bits in the hour plus the minute equals turnedOn. Format H:MM with no leading hour zero. turnedOn=1 → ten times like 0:01 and 8:00. turnedOn=9 → []. Enumerate 12×60. Not 191.',
    'category' => 'LeetCode',
    'subcategory' => 'Bit Manipulation',
    'topic' => 'LeetCode · Bit Manipulation',
    'kind' => 'algo',
    'tags' => ['bit-manipulation', 'backtracking', 'leetcode'],
    'related_session' => 'binary-watch',
];
