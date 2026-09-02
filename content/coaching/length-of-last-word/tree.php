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
            'message' => "Problem: length of the last word (max non-space substring). \"Hello World\" → 5. Trailing spaces: \"   fly me   to   the moon  \" → 4. At least one word. n up to 1e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Split on every space character and take the length of the last token', 'next' => 'split'],
                ['label' => 'From the end: skip spaces, then walk back over letters; answer is i - j', 'next' => 'scan'],
            ],
        ],
        'split' => [
            'message' => "Splitting on every space keeps empty tokens after trailing spaces, so the last piece can be length 0.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the length of the whole string; spaces do not count as a separate issue', 'next' => 'wrong_all'],
                ['label' => 'i = n-1; while s[i] is space, i--; j = i; while s[j] is not space, j--; return i-j', 'next' => 'scan'],
            ],
        ],
        'wrong_all' => [
            'message' => "You are wrong here.\n\"Hello World\" has length 11, but the last word is 5. You need one token, not the whole line.\nStep back to when you measured the string.",
            'outcome' => 'wrong',
            'rewind_to' => 'split',
            'choices' => [],
        ],
        'scan' => [
            'message' => "Why skip spaces before counting letters?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The last characters may be padding spaces; the word sits just left of that run', 'next' => 'example'],
                ['label' => 'The last character is always a letter, so start counting from n-1', 'next' => 'wrong_noskip'],
            ],
        ],
        'wrong_noskip' => [
            'message' => "You are wrong. Example 2 ends with spaces. Starting a letter-count at n-1 would yield 0.\nStep back to when you skipped the tail spaces.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'example' => [
            'message' => "After the second while, j sits on the space (or -1) before the word, so i - j is the letter count. No extra string copy.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) extra', 'next' => 'success'],
                ['label' => 'O(n) extra: you must trim and split into a new array of words', 'next' => 'wrong_space'],
            ],
        ],
        'wrong_space' => [
            'message' => "You are wrong. Two indices from the right are enough. The writeup uses O(1) extra space.\nStep back to when you allocated tokens.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. From the end, skip spaces, then skip non-spaces. Return i - j. Time O(n), extra O(1). Not split-on-every-space (empty tail tokens), and not the length of the whole string.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
