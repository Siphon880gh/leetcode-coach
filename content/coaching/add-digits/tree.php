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
            'message' => "Problem: repeatedly add digits until one digit remains. 38 → 2 (3+8=11, then 1+1=2). 0 → 0. Follow-up: O(1), no loop.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Happy Number: sum squares of digits until 1 or a cycle', 'next' => 'happy'],
                ['label' => 'Digital root: a number ≡ sum of digits (mod 9); compact form (num − 1) mod 9 plus 1', 'next' => 'root'],
            ],
        ],
        'happy' => [
            'message' => "202 squares each digit. Here you add digits as-is. A loop while num ≥ 10 is correct but the follow-up forbids it.\nWhat about multiples of 9?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '0 stays 0. 9, 18, 27 map to 9, not 0. That is why (num − 1) mod 9 plus 1', 'next' => 'root'],
                ['label' => 'Return num mod 9 even when num is 9 (that is 0)', 'next' => 'wrong_mod'],
            ],
        ],
        'wrong_mod' => [
            'message' => "You are wrong here.\n9 must return 9. num mod 9 sends 9 to 0. Use (num − 1) mod 9 plus 1, and treat 0 separately if your language’s mod of −1 is not 8.\nStep back to when you used num mod 9.",
            'outcome' => 'wrong',
            'rewind_to' => 'happy',
            'choices' => [],
        ],
        'root' => [
            'message' => "38 → (37 mod 9) + 1 = 2. First Bad Version is a binary search API, not a digital root.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '38 → 2, 0 → 0, 9 → 9', 'next' => 'cpx'],
                ['label' => 'First Bad Version: binary-search the first digit that is bad', 'next' => 'wrong_bad'],
            ],
        ],
        'wrong_bad' => [
            'message' => "You are wrong. First Bad Version searches versions with isBadVersion. This problem is a digital root.\nStep back to when you swapped problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'root',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(1) time and space. Not Happy Number squares, not num mod 9 for 9, not a loop of summing digits for the follow-up.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '0 if num is 0, else (num − 1) mod 9 plus 1', 'next' => 'success'],
                ['label' => 'Square each digit then add, like Happy Number', 'next' => 'wrong_sq'],
            ],
        ],
        'wrong_sq' => [
            'message' => "You are wrong. Add the digits; do not square them. 38 would become 9+64, not 11.\nStep back to when you squared.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Digital root. 0 stays 0. Otherwise (num − 1) mod 9 plus 1 so 9 maps to 9. Do not square digits, return 0 for 9, or binary-search versions.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
