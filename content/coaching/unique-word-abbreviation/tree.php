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
            'message' => "Problem: ValidWordAbbr. Abbr is first letter, count of letters between, last letter (length under 3 stays itself). isUnique(word) is true if no other dictionary word shares that abbr. Sample: cake is unique; dear is not (deer).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'If word is already in the dictionary, return false', 'next' => 'wrong_self'],
                ['label' => 'Map each abbr to a set of dictionary words', 'next' => 'map'],
            ],
        ],
        'wrong_self' => [
            'message' => "You are wrong here.\ncake is in the dictionary and isUnique(\"cake\") is true — no other word has c2e. Being present is allowed.\nStep back to when you rejected dictionary words.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'map' => [
            'message' => "abbr: len < 3 → the word; else s[0] + str(len − 2) + last. d[abbr].add(word). isUnique: missing key, or the set has size 1 and contains word. Duplicate dictionary entries collapse in the set.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Store one word per abbr and overwrite (deer then door hides the conflict)', 'next' => 'wrong_over'],
                ['label' => 'O(n) build, O(1) isUnique. deer and door both d2r → not unique', 'next' => 'cpx'],
            ],
        ],
        'wrong_over' => [
            'message' => "You are wrong. Overwriting keeps only the last word. deer and door both map to d2r; you must see two distinct strings.\nStep back to when you stored a single word.",
            'outcome' => 'wrong',
            'rewind_to' => 'map',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) space. Not a Trie of prefixes. Not Generalized Abbreviation (320).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Set per abbr. cake unique, dear not. Not “in dict ⇒ false”, not overwrite', 'next' => 'success'],
                ['label' => 'Count words per abbr; unique iff the count is 0, even when the only word is this one', 'next' => 'wrong_cnt'],
            ],
        ],
        'wrong_cnt' => [
            'message' => "You are wrong. A count of 1 is unique only if that word is the query. A count does not tell you which word it was. Use a set (or store one word plus a conflict flag).\nStep back to when you used a bare count.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Canonical abbr, set of words. isUnique if empty or {word}. cake true, dear false. Not “in dictionary means false.”\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
