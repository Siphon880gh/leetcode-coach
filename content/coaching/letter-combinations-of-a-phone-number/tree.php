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
            'message' => "Problem: letter combinations of a phone number. \"23\" → [\"ad\",\"ae\",\"af\",\"bd\",\"be\",\"bf\",\"cd\",\"ce\",\"cf\"]. Digits are 2–9 only; 7 and 9 have four letters.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Concatenate every mapped letter into one string per input', 'next' => 'concat'],
                ['label' => 'Map each digit to its letters, then take the cartesian product across digits', 'next' => 'product'],
            ],
        ],
        'concat' => [
            'message' => "\"23\" is not \"abcdef\". Each output string has one letter from 2 and one from 3 — a product, not a join.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the mapping table itself — the judge only needs the letters that appear', 'next' => 'wrong_map'],
                ['label' => "Seed ans = [\"\"]; for each digit, replace ans with every old prefix plus each new letter", 'next' => 'product'],
            ],
        ],
        'wrong_map' => [
            'message' => "You are wrong here.\nThe answer is every combination string, not the keypad dictionary.\nStep back to when you chose what to emit.",
            'outcome' => 'wrong',
            'rewind_to' => 'concat',
            'choices' => [],
        ],
        'product' => [
            'message' => "d = [\"abc\",\"def\",\"ghi\",\"jkl\",\"mno\",\"pqrs\",\"tuv\",\"wxyz\"], index digit − 2. Empty digits → [].\nHow do you grow one more digit?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'ans = [a + b for a in ans for b in letters(digit)] — same idea as DFS that appends then pops', 'next' => 'example'],
                ['label' => 'Push each new letter as its own one-character string and ignore previous prefixes', 'next' => 'wrong_reset'],
            ],
        ],
        'wrong_reset' => [
            'message' => "You are wrong. Dropping the prefix loses earlier digits. \"23\" would collapse to just d, e, f.\nStep back to when you chose how to extend ans.",
            'outcome' => 'wrong',
            'rewind_to' => 'product',
            'choices' => [],
        ],
        'example' => [
            'message' => "\"23\": start [\"\"], after 2 → [a,b,c], after 3 → [ad,ae,af,bd,be,bf,cd,ce,cf]. \"7\" uses four letters pqrs.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(4^n) time and space — n digits, at most 4 letters each, n ≤ 4', 'next' => 'success'],
                ['label' => 'O(n) because you loop the digits once and hash the keypad', 'next' => 'wrong_linear'],
            ],
        ],
        'wrong_linear' => [
            'message' => "You are wrong. Each extra digit multiplies the list. Output size is exponential in n, so the work is too.\nStep back to when you scored the expansion.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Map 2–9 to letters. If digits is empty, return []. Fold: for each digit, every existing prefix times each letter (iterative product or backtracking). Time O(4^n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
