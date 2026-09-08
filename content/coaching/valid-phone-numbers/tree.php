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
            'message' => "Problem: bash on file.txt, one candidate per line, no extra spaces. Keep exactly ddd-ddd-dddd or (ddd) ddd-dddd. Sample: 987-123-4567 and (123) 456-7890 print; 123 456 7890 does not.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Word Frequency pipes, or keep any line that contains ten digits somewhere', 'next' => 'other'],
                ['label' => 'awk with start and end anchors: hyphen form or paren, space, then ddd-dddd', 'next' => 'awk'],
            ],
        ],
        'other' => [
            'message' => "This is a per-line keep-or-drop, not a word count. Ten digits with spaces in between is the invalid sample.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Match the core anywhere; junk around a valid number is fine', 'next' => 'wrong_sub'],
                ['label' => 'Whole-line regex: two formats only', 'next' => 'awk'],
            ],
        ],
        'wrong_sub' => [
            'message' => "You are wrong here.\nWithout start and end anchors, extra characters around a valid core would print. The line must be the number and nothing else.\nStep back to when you matched a substring.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'awk' => [
            'message' => "Shared tail is three digits, hyphen, four digits. First branch is ddd- ; second is (ddd) plus a space. grep -E is the same filter.\nWhich sample lines print?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '987-123-4567 and (123) 456-7890', 'next' => 'cpx'],
                ['label' => 'All three, including 123 456 7890', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Three space-separated groups is not either format.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'awk',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "One pass over the file: O(n). Extra space is the current line.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Anchored awk; (ddd) needs the space after the paren', 'next' => 'success'],
                ['label' => '(ddd)ddd-dddd with no space is also valid', 'next' => 'wrong_space'],
            ],
        ],
        'wrong_space' => [
            'message' => "You are wrong. The second format is (ddd) space ddd-dddd. Dropping the space is a different string.\nStep back to when you dropped the space.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Whole-line hyphen form or paren-plus-space form. Not a substring hunt, not space-separated triples. O(n) / O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
