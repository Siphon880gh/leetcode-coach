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
            'message' => "Problem: column number → Excel title. A=1 … Z=26, AA=27, AB=28. 1 → A. 28 → AB. 701 → ZY.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Plain 0-based base-26, Two Sum II pointers, or the inverse (title to number)', 'next' => 'base0'],
                ['label' => 'Repeatedly n -= 1, emit A + n%26, then n //= 26; reverse the letters', 'next' => 'sub'],
            ],
        ],
        'base0' => [
            'message' => "Excel is 1-based: there is no 0 digit. Skipping n -= 1 maps 26 to a remainder 0 and the extra quotient 1, which is not Z. Title-to-number is a later problem. Two Sum II is pointers.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat 26 as AA because 26 = 1*26 + 0', 'next' => 'wrong_aa'],
                ['label' => 'Subtract 1 so remainder 0 means Z, then integer-divide by 26', 'next' => 'sub'],
            ],
        ],
        'wrong_aa' => [
            'message' => "You are wrong here.\n26 is Z, not AA. AA is 27. The subtract-1 shift is what makes 26 land on Z.\nStep back to when you mapped 26 to two letters.",
            'outcome' => 'wrong',
            'rewind_to' => 'base0',
            'choices' => [],
        ],
        'sub' => [
            'message' => "Letters come out least-significant first, so reverse at the end. Walk 28: 28-1=27, 27%26=1 → B, 27//26=1; then 1-1=0, 0%26=0 → A; reverse → AB.\nWhat is 701?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'ZY — 700%26 is Y, then 26 becomes Z after the next subtract-1', 'next' => 'ans'],
                ['label' => 'AB like 28, or ZZ as if 26*26', 'next' => 'wrong_zy'],
            ],
        ],
        'wrong_zy' => [
            'message' => "You are wrong. 701 is ZY, not a copy of the 28 sample and not ZZ.\nStep back to when you converted 701.",
            'outcome' => 'wrong',
            'rewind_to' => 'sub',
            'choices' => [],
        ],
        'ans' => [
            'message' => "1 is A. Time O(log n). Not Two Sum II, not title-to-number.\nWhat is 1?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A', 'next' => 'success'],
                ['label' => 'AB or ZY from the other samples', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. Column 1 is a single A. Do not reuse 28 or 701.\nStep back to when you scored 1.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. n -= 1, A + n%26, n //= 26, reverse. 26 is Z, not AA. Not Two Sum II, not the inverse mapping. 28 → AB. 701 → ZY.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
