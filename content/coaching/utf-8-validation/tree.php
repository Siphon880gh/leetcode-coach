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
            'message' => "Problem: data is bytes (low 8 bits of each int, 0..255, length up to 2e4). Return true iff they form valid UTF-8 of 1-to-4-byte characters: 0xxxxxxx; 110xxxxx then 10xxxxxx; 1110xxxx plus two 10s; 11110xxx plus three 10s. [197,130,1] → true. [235,140,4] → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat this as Decode String (394), or accept 5-byte 111110 leads', 'next' => 'wrong_394'],
                ['label' => 'Track how many 10xxxxxx bytes are still owed after each lead', 'next' => 'cnt'],
            ],
        ],
        'wrong_394' => [
            'message' => "You are wrong here. 394 parses k[encoded] brackets, not UTF-8. A 5-byte lead 111110xx is not in the 1-to-4-byte table.\nStep back to when you used 394 or allowed 5-byte leads.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'cnt' => [
            'message' => "cnt starts at 0. If cnt is positive, the byte must start with 10, then decrement. Else it is a lead: 0xxxxxxx needs 0 more; 110xxxxx needs 1; 1110xxxx needs 2; 11110xxx needs 3; anything else (bare 10 lead, 111110) is false.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat a continuation as a new character while cnt is still positive', 'next' => 'wrong_cont'],
                ['label' => 'While cnt is due, only 10xxxxxx is legal. After the last byte cnt must be 0', 'next' => 'kind'],
            ],
        ],
        'wrong_cont' => [
            'message' => "You are wrong. [235,140,4] has a 3-byte lead and one good 10, then 00000100 is not 10xxxxxx — false. You cannot start a new character until cnt is 0.\nStep back to when you ignored cnt.",
            'outcome' => 'wrong',
            'rewind_to' => 'cnt',
            'choices' => [],
        ],
        'kind' => [
            'message' => "This problem only checks the bit templates, not Unicode overlong encodings. [197,130,1] is a 2-byte char then a 1-byte char.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Continuation count. Leftover cnt at the end is false. Not 394', 'next' => 'success'],
                ['label' => 'Return true while cnt is still positive, or skip checking the 10 prefix', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. An unfinished character (cnt still positive) is invalid. A continuation that is not 10xxxxxx is invalid.\nStep back to when you allowed leftover cnt or skipped the 10 check.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Track remaining 10xxxxxx bytes. [197,130,1] true. [235,140,4] false. End with cnt 0. Not 394.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
