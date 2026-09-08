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
            'message' => "Problem: print the 10th line of file.txt. Sample tenth line is Line 10. Fewer than 10 lines → print nothing.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'cat the whole file, or grep for the string 10', 'next' => 'other'],
                ['label' => 'sed -n 10p, or awk NR==10', 'next' => 'sed'],
            ],
        ],
        'other' => [
            'message' => "Dumping the file is not “just the 10th line.” Searching for the characters 1 and 0 can match Line 10 in the sample but is not “line number 10.”\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always invent a tenth line when the file is short', 'next' => 'wrong_short'],
                ['label' => 'Address by line number; stay quiet if EOF comes first', 'next' => 'sed'],
            ],
        ],
        'wrong_short' => [
            'message' => "You are wrong here.\nA short file should print nothing, not a fake Line 10.\nStep back to when you padded the file.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'sed' => [
            'message' => "-n is quiet except p on line 10. head -n 10 | tail -n 1 is a twin when there are at least 10 lines.\nWhat does the sample print?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Line 10', 'next' => 'cpx'],
                ['label' => 'Line 1, or the whole file', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. The tenth line is Line 10, not the first line and not every line.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'sed',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Scan until line 10 or EOF: O(n). Extra space is the current line.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'sed -n 10p; short files emit nothing', 'next' => 'success'],
                ['label' => 'Print lines 1 through 10', 'next' => 'wrong_range'],
            ],
        ],
        'wrong_range' => [
            'message' => "You are wrong. The problem is one line, not a prefix of the file.\nStep back to when you printed a range.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. sed -n 10p (or awk NR==10). Not cat, not grep for 10, not a padded short file. O(n) / O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
