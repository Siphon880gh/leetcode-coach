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
            'message' => "Problem: all generalized abbreviations of word. Replace non-overlapping, non-adjacent substrings with their lengths. \"word\" has 16 forms (\"4\", \"3d\", \"2r1\", \"word\", …). \"a\" → [\"1\",\"a\"]. \"23\" from \"abcde\" is illegal (adjacent replacements). Length 1..15, lowercase.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allow adjacent counts like 23, or Unique Word Abbreviation (288)', 'next' => 'wrong_adj'],
                ['label' => 'Bit mask: 1 abbreviates, 0 keeps; flush the run when you keep a letter', 'next' => 'mask'],
            ],
        ],
        'wrong_adj' => [
            'message' => "You are wrong here.\nAdjacent replaced blocks merge into one number (\"23\" should be \"5\"). 288 asks whether one abbreviation is unique in a dictionary.\nStep back to when you allowed adjacent counts or reused 288.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'mask' => [
            'message' => "n ≤ 15, so walk every mask in 0 .. 2ⁿ − 1. Bit 1: add to a run. Bit 0: if the run is positive, append the decimal count, then append the letter, reset the run. After the last index, flush a leftover run. DFS twin: keep word[i], or skip word[i..j) and then must keep word[j] (or finish).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Overlap two replaced ranges, or skip flushing the run at the end of the word', 'next' => 'wrong_flush'],
                ['label' => 'O(n × 2ⁿ). Order of the list does not matter', 'next' => 'cpx'],
            ],
        ],
        'wrong_flush' => [
            'message' => "You are wrong. Replaced ranges cannot overlap. A trailing abbreviated suffix needs its count written after the last letter.\nStep back to when you overlapped ranges or dropped a leftover run.",
            'outcome' => 'wrong',
            'rewind_to' => 'mask',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "A number is written only when a kept letter (or the end) closes the run, so two digits never sit next to each other.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep or count a run; never adjacent numbers. 16 forms for word', 'next' => 'success'],
                ['label' => 'Return only the full word and the single number n (two extremes)', 'next' => 'wrong_two'],
            ],
        ],
        'wrong_two' => [
            'message' => "You are wrong. Partial keeps count: \"word\" includes \"w3\", \"1o2\", and 13 more besides \"word\" and \"4\".\nStep back to when you kept only the two extremes.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One bit per character. Flush the run on a keep (and at the end). Adjacent numbers never appear. O(n × 2ⁿ).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
