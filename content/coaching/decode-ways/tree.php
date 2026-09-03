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
            'message' => "Problem: count ways to map a digit string to A–Z (1..26). 12 → 2. 226 → 3. 06 → 0. Length ≤ 100.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Climbing Stairs: always add f[i-1]+f[i-2], even on a 0', 'next' => 'stairs'],
                ['label' => 'DP: f[0]=1; single digit if not 0; plus two-digit if 10..26', 'next' => 'dp'],
            ],
        ],
        'stairs' => [
            'message' => "The Fibonacci shape is the same, but a 0 cannot stand alone, and 27 is not a letter. 06 is 0 ways, not 1.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Parse as atoi / Valid Number: one integer, one mapping', 'next' => 'wrong_atoi'],
                ['label' => 'If s[i-1] is not 0, take f[i-1]; if the pair is 10..26, add f[i-2]', 'next' => 'dp'],
            ],
        ],
        'wrong_atoi' => [
            'message' => "You are wrong here.\nAtoi reads one number. Decode Ways counts partitions into 1–26 codes.\nStep back to when you treated this as one integer.",
            'outcome' => 'wrong',
            'rewind_to' => 'stairs',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Why is f[0] = 1, and why does a leading 0 make f[1] stay 0?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Empty prefix has one empty decode; a lone 0 is not a letter, so no one-digit take', 'next' => 'ret'],
                ['label' => 'f[0] = 0 because nothing is decoded yet; a leading 0 still maps to Z somehow', 'next' => 'wrong_z'],
            ],
        ],
        'wrong_z' => [
            'message' => "You are wrong. 06 is not F. Only 6 is F. A code cannot start with 0.\nStep back to when you allowed a leading 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return f[n]. Time O(n). Not Unique Paths (grid), not regex matching.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The count of valid decodes — 0 if impossible', 'next' => 'success'],
                ['label' => 'One decoded string, like Integer to Roman', 'next' => 'wrong_str'],
            ],
        ],
        'wrong_str' => [
            'message' => "You are wrong. Integer to Roman emits one numeral. This returns how many encodings exist.\nStep back to when you returned a string.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f[0]=1. For each i: if s[i-1] ≠ 0 then f[i]=f[i-1]; if the two-digit slice is 10..26, add f[i-2]. Return f[n]. O(n). Not unconstrained Climbing Stairs, not atoi, not Unique Paths.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
