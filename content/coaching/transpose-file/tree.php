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
            'message' => "Problem: transpose file.txt. Same number of space-separated fields per row. Sample name age / alice 21 / ryan 30 → name alice ryan and age 21 30.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Rotate Image in RAM, or print the original rows again', 'next' => 'other'],
                ['label' => 'awk: for each field i, seed res[i] on row 1, else append a space and the field; print at END', 'next' => 'awk'],
            ],
        ],
        'other' => [
            'message' => "This is a text file, not an n by n matrix. Reprinting rows is not a transpose.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Join fields with commas, or swap only the two header words', 'next' => 'wrong_join'],
                ['label' => 'One string per old column; later rows append', 'next' => 'awk'],
            ],
        ],
        'wrong_join' => [
            'message' => "You are wrong here.\nFields stay space-separated. The whole file transposes, not just the header.\nStep back to when you joined with commas.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'awk' => [
            'message' => "NF is columns, NR is the row. END prints res[1] through res[NF], each on its own line.\nWhat are the two output lines?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'name alice ryan, then age 21 30', 'next' => 'cpx'],
                ['label' => 'name age, then alice 21, then ryan 30 (original rows)', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Old columns become new rows: names in one line, ages in the next.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'awk',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time and extra space are both rows times columns (the stored column strings).\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'First row seeds; later rows append space plus field; print columns at END', 'next' => 'success'],
                ['label' => 'Print inside the per-row loop so each cell is its own line', 'next' => 'wrong_print'],
            ],
        ],
        'wrong_print' => [
            'message' => "You are wrong. Printing inside the row loop dumps cells, not completed column strings. Accumulation finishes at END.\nStep back to when you printed early.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. awk one string per column: seed on row 1, append later, print at END. Not Rotate Image, not reprinting rows. O(rows times columns).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
