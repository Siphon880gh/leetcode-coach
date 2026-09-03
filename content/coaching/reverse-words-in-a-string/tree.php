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
            'message' => "Problem: reverse the order of words in s. Collapse extra spaces; no leading or trailing space. the sky is blue → blue is sky the. A padded hello world → world hello. At least one word.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse every character, Length of Last Word’s count only, RPN’s operator stack, or Simplify Path pops', 'next' => 'chars'],
                ['label' => 'Two pointers: skip spaces, take each word, reverse the word list, join with one space', 'next' => 'scan'],
            ],
        ],
        'chars' => [
            'message' => "Reversing characters would scramble letters inside each word. Length of Last Word only returns a length. RPN and Simplify Path are different stacks.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep the original spaces, including doubles and padding', 'next' => 'wrong_spaces'],
                ['label' => 'Split on whitespace into words, then reverse that list', 'next' => 'scan'],
            ],
        ],
        'wrong_spaces' => [
            'message' => "You are wrong here.\nThe output uses exactly one space between words and none at the ends. a good then three spaces then example becomes example good a.\nStep back to when you kept the padding.",
            'outcome' => 'wrong',
            'rewind_to' => 'chars',
            'choices' => [],
        ],
        'scan' => [
            'message' => "i skips spaces; j runs to the next space; append s[i:j]; i = j. Then join(words[::-1]) with a single space. Python split() with no args does the same skip-and-split.\nWhat does a padded hello world return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'world hello — two words, no padding', 'next' => 'ret'],
                ['label' => 'hello world unchanged, or olleh dlrow', 'next' => 'wrong_pad'],
            ],
        ],
        'wrong_pad' => [
            'message' => "You are wrong. Word order flips; letters inside a word stay. Padding is stripped.\nStep back to when you left the string or reversed letters.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(n), extra O(n) for the word list. Follow-up in-place: reverse the whole buffer, then reverse each word, squeezing spaces as you copy. At least one word, so the result is never empty.\nWhat is the sky is blue after reverse?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'blue is sky the', 'next' => 'success'],
                ['label' => 'eulb si yks eht, or the sky is blue', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Reverse word order, not characters, and do not leave the original order.\nStep back to when you mixed reverse-string with reverse-words.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Skip spaces, collect words, reverse the list, join with one space. O(n). Not reverse-characters, not Length of Last Word, not RPN, not Simplify Path, not keeping extra spaces.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
