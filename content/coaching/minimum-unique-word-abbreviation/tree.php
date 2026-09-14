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
            'message' => "Problem: target length m is 1 to 21. dictionary has up to 1000 other lowercase words (never equal to target). Return a shortest abbreviation of target that is not a valid abbreviation of any dictionary word. Length counts kept letters plus replaced runs (s10n has length 3). apple / [blade] → a4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Validate with 408, or list every abbreviation of target (320) and pick the first', 'next' => 'wrong_408'],
                ['label' => 'Only same-length dictionary words matter. Encode diffs as bitmasks; search keep-masks', 'next' => 'masks'],
            ],
        ],
        'wrong_408' => [
            'message' => "You are wrong here. 408 checks one word against one abbr. 320 lists abbreviations of one word with no dictionary. Unique Word Abbreviation (288) is a different uniqueness question over a whole dict.\nStep back to when you used 408 or 320 without the dict masks.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'masks' => [
            'message' => "If no same-length dict word remains, return the decimal m (the whole word as one number). Else each remaining word is a bitmask of positions that differ from target. A keep-mask (1 = keep that letter) is unique iff it shares a 1 with every diff mask. Among those, write the abbreviation and pick the smallest length.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return 5 for apple vs blade, or score a two-digit run as two length units', 'next' => 'wrong_5'],
                ['label' => '5 abbreviates blade too. a4 keeps the a that blade does not have. A run of 10 counts as 1', 'next' => 'kind'],
            ],
        ],
        'wrong_5' => [
            'message' => "You are wrong. 5 matches any 5-letter word. Abbreviation length is kept letters plus the count of runs, so 10 is one run, not two digits of cost.\nStep back to when you returned 5 or scored digits as separate units.",
            'outcome' => 'wrong',
            'rewind_to' => 'masks',
            'choices' => [],
        ],
        'kind' => [
            'message' => "apple vs blade,plain,amber can return 1p3, 2p2, or 3l1. Different-length dict words cannot share an abbreviation. Adjacent replaced runs are illegal, same as 320.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep bits that hit every diff mask. apple / [blade] → a4. Not 408 / 320', 'next' => 'success'],
                ['label' => 'Require the abbreviation to stay unique against shorter or longer dictionary words too', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. An abbreviation of a length-m word cannot be a valid abbreviation of a different-length word (the skipped-letter total would not match).\nStep back to when you filtered the wrong lengths.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Same-length diffs as bitmasks. A keep-mask must hit every mask. Minimize letters plus runs. apple / [blade] → a4. Not 408.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
