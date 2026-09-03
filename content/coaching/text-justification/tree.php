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
            'message' => "Problem: pack words into lines of exactly maxWidth. Greedy: as many words as fit. Extra spaces even; leftover extra spaces go to the left gaps. Last line is left-justified. maxWidth=16, last line is \"shall be\" plus trailing pad, not extra gaps between the two words.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Fully justify every line the same way, including the last', 'next' => 'same'],
                ['label' => 'Greedy pack; if last line or one word, left-join and pad; else even gaps with extra on the left', 'next' => 'pack'],
            ],
        ],
        'same' => [
            'message' => "Example 2 last line is left-justified: one space between shall and be, then pad to maxWidth. Fully justifying would put extra spaces between those two words.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Put leftover extra spaces on the right gaps instead', 'next' => 'wrong_right'],
                ['label' => 'Last line (and a one-word line) is left-justified: single spaces, pad after the last word', 'next' => 'pack'],
            ],
        ],
        'wrong_right' => [
            'message' => "You are wrong here.\nLeftover extras go to the left slots on middle lines. That is a separate rule from last-line left-justify.\nStep back to when you applied the same gap rule everywhere.",
            'outcome' => 'wrong',
            'rewind_to' => 'same',
            'choices' => [],
        ],
        'pack' => [
            'message' => "A line with one word (\"acknowledgment\") has zero gaps. Why left-justify it instead of dividing spaces by len(t)-1?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'There is no slot between words; pad after the word. Dividing by 0 is wrong', 'next' => 'gaps'],
                ['label' => 'Treat it as a middle line and still fully justify by inventing a gap', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. The writeup left-justifies when i==n (last line) or len(t)==1. One word gets trailing spaces only.\nStep back to when you invented a gap.",
            'outcome' => 'wrong',
            'rewind_to' => 'pack',
            'choices' => [],
        ],
        'gaps' => [
            'message' => "On a middle line with k words, k-1 gaps: base width w, remainder m. Gap j gets w+1 for j < m. Time O(L).\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A list of strings each of length maxWidth — not Length of Last Word', 'next' => 'success'],
                ['label' => 'The length of the last packed word', 'next' => 'wrong_len'],
            ],
        ],
        'wrong_len' => [
            'message' => "You are wrong. This problem returns justified lines. Length of Last Word only counts the last token.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'gaps',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Pack greedily with a 1-space minimum. Last line or one word: join with one space, pad the end. Other lines: leftover extras go to the left gaps. Time O(L). Not fully justifying the last line, and not Length of Last Word.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
