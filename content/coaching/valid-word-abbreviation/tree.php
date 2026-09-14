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
            'message' => "Problem: word length 1 to 20, abbr length 1 to 10. An abbreviation replaces non-adjacent nonempty substrings with their lengths; those lengths must not have leading zeros. Does abbr match word? internationalization / i12iz4n → true. apple / a2e → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Generate every abbreviation of word (320) and see if abbr is in the list', 'next' => 'wrong_320'],
                ['label' => 'Two pointers: digits accumulate a skip count; letters must match after skipping', 'next' => 'scan'],
            ],
        ],
        'wrong_320' => [
            'message' => "You are wrong here. Generalized Abbreviation (320) asks you to list every possible abbr. Here you only validate one string against one word, in linear time.\nStep back to when you generated the full list.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'scan' => [
            'message' => "i on word, j on abbr, x = pending skip. Digit: if the digit is 0 and x is still 0, reject (leading zero or empty skip). Else x = x times 10 plus that digit. Letter: i += x, x = 0, then word[i] must equal abbr[j] and i must stay in range. After the loop, i + x must equal the word length and j must have used all of abbr.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allow s010n / s0ubstitution, or treat a2e as matching apple', 'next' => 'wrong_zero'],
                ['label' => 'Reject a leading 0. apple / a2e is false because after skip 2 you hit l, not e', 'next' => 'kind'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. A leading 0 is illegal (empty replacement or padded number). a2e skips two letters after a and needs e next, but apple has l there, so false.\nStep back to when you allowed a leading 0 or accepted a2e.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Adjacent number chunks like s55n would try to skip 5 then 5 with no letter between — that is two adjacent replacements, which the statement forbids; the scan still just applies 55 as one number unless you split them. Minimum Unique Word Abbreviation (411) is a different search.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip digits, reject leading zeros. i12iz4n true. a2e false. Not 320', 'next' => 'success'],
                ['label' => 'Allow i12iz4n to fail because 12 and 4 are not the only possible splits', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. You do not have to find every split. You only check whether this one abbr walks the word exactly.\nStep back to when you required a unique split.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Two pointers, skip count from digits, reject leading zeros. Finish with i+x equal to the word length. Not 320.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
