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
            'message' => "Problem: encode a list of strings to one string, then decode back. Strings may be empty and may hold any ASCII, including commas and hashes. [\"Hello\",\"World\"] round-trips. [\"\"] is one empty string.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Join with commas (or hashes) and split, or eval a Python list', 'next' => 'join'],
                ['label' => 'Prefix each payload with its length, then write the bytes', 'next' => 'prefix'],
            ],
        ],
        'join' => [
            'message' => "A comma (or #) can sit inside a payload, so split is ambiguous. eval is banned. You need a length the decoder can parse without guessing.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Escape every special character and hope the alphabet stays small', 'next' => 'wrong_escape'],
                ['label' => 'Write a fixed-width length (four digits is enough), then the payload', 'next' => 'prefix'],
            ],
        ],
        'wrong_escape' => [
            'message' => "You are wrong here.\nAny ASCII is allowed. Escaping a growing set of specials is brittle. Length then bytes works for all 256 codes.\nStep back to when you chose a delimiter scheme.",
            'outcome' => 'wrong',
            'rewind_to' => 'join',
            'choices' => [],
        ],
        'prefix' => [
            'message' => "Encode: for each s, append '{:4}'.format(len(s)) then s. Decode: while i < n, size = int(s[i:i+4]), take the next size characters, advance.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '["Hello","World"] and [""] both round-trip. Empty is length 0 plus no payload', 'next' => 'cpx'],
                ['label' => 'Stop at the first # inside the payload; treat # as an end-of-string mark', 'next' => 'wrong_hash'],
            ],
        ],
        'wrong_hash' => [
            'message' => "You are wrong. If you use length#payload, the # only ends the length digits. A # inside the payload is data.\nStep back to when you treated # as a string terminator.",
            'outcome' => 'wrong',
            'rewind_to' => 'prefix',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(total characters) time and space. Serialize Binary Tree prefixes a tree; here there is no tree, only a list.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Length then payload. Not comma-join, not eval, not a payload delimiter', 'next' => 'success'],
                ['label' => 'Four bytes as a raw integer is required; a decimal width cannot work', 'next' => 'wrong_raw'],
            ],
        ],
        'wrong_raw' => [
            'message' => "You are wrong. Python's four-character decimal width and a raw size byte both work. The invariant is: parse a length, then that many characters.\nStep back to when you required a binary size field.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Encode length then bytes. Decode by reading the length, then that many characters. Empty strings are length 0. Not a naive join, not eval.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
