<?php
declare(strict_types=1);

/**
 * Step-by-step tree contract:
 * - start: node id
 * - nodes[id]: message, outcome (continue|wrong|success), choices[{label, next}], optional rewind_to on wrong
 */
return [
    'start' => 'start',
    'nodes' => [
        'start' => [
            'message' => "Problem: turnedOn is 0..10. A watch has 4 hour bits (0–11) and 6 minute bits (0–59). Return every valid time whose total 1-bits equal turnedOn. Hour has no leading zero (1:00 not 01:00). Minutes are two digits (10:02 not 10:2). Any order. turnedOn=1 includes 0:01 and 8:00. turnedOn=9 is empty.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat this as Number of 1 Bits (191) on a single int, or use hours 0–23', 'next' => 'wrong_191'],
                ['label' => 'Enumerate hour 0–11 and minute 0–59; keep pairs whose popcounts sum to turnedOn', 'next' => 'enum'],
            ],
        ],
        'wrong_191' => [
            'message' => "You are wrong here. 191 counts bits of one number. Hours stop at 11 (the 8+2+1 LEDs), not 23. A 24-hour value 13 cannot appear.\nStep back to when you used 191 or a 24-hour clock.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'enum' => [
            'message' => "720 pairs is constant time. bitCount(h) + bitCount(m) == turnedOn. Format as h, colon, m padded to 2 digits. Backtracking over 10 LEDs also works if you skip invalid hours and minutes.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Pad the hour to two digits, or skip padding minutes like 0:1', 'next' => 'wrong_fmt'],
                ['label' => 'Hour unpadded, minutes always two digits. Empty when no pair hits the count', 'next' => 'kind'],
            ],
        ],
        'wrong_fmt' => [
            'message' => "You are wrong. 1:00 is valid; 01:00 is not. 0:01 is valid; 0:1 is not.\nStep back to when you padded the hour or skipped the minute pad.",
            'outcome' => 'wrong',
            'rewind_to' => 'enum',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Max 1-bits among valid times is 8 (11 is three bits, 59 is five), so turnedOn=9 and 10 return empty even though 10 LEDs exist. turnedOn=0 is 0:00.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Enumerate 12 by 60. turnedOn=1 has ten times. Not 191', 'next' => 'success'],
                ['label' => 'Allow 12:00 as an hour, or treat turnedOn as minutes only', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Hour 12 is invalid on this 0–11 display. turnedOn counts hour LEDs and minute LEDs together.\nStep back to when you allowed hour 12 or ignored hour bits.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Hours 0–11, minutes 0–59, popcounts sum to turnedOn. Format H:MM. turnedOn=9 is empty. Not 191.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
