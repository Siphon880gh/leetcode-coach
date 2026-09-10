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
            'message' => "Problem: group strings that sit on the same wrap-around Caesar sequence (z→a). Any group order. [\"abc\",\"bcd\",\"acef\",\"xyz\",\"az\",\"ba\",\"a\",\"z\"] has four groups.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Group Anagrams: sort letters as the key; or bucket by length only', 'next' => 'ana'],
                ['label' => 'Shift the word so the first letter is a (add 26 on wrap); map that key to originals', 'next' => 'shift'],
            ],
        ],
        'ana' => [
            'message' => "\"abc\" and \"cba\" share a sorted key but are not shifts. Length-4 \"acef\" is a singleton; abc/bcd/xyz share length 3 and a family. Alien Dictionary is letter-order from consecutive words, not Caesar buckets.\nWhat is the fingerprint?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'diff = s[0] − a; each char minus diff; if below a, plus 26. \"bcd\" and \"xyz\" both become \"abc\"', 'next' => 'shift'],
                ['label' => 'Skip the wrap: \"za\" and \"ab\" stay in different groups', 'next' => 'wrong_wrap'],
            ],
        ],
        'wrong_wrap' => [
            'message' => "You are wrong here.\n\"za\" minus 25 wraps to key \"ab\", same as \"ab\". Wrap is required.\nStep back to when you skipped wrap.",
            'outcome' => 'wrong',
            'rewind_to' => 'ana',
            'choices' => [],
        ],
        'shift' => [
            'message' => "Keep originals in the lists. \"ba\" and \"az\" share a key. Single letters all map to \"a\".\nWhich groups?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '{abc,bcd,xyz}, {az,ba}, {a,z}, {acef}', 'next' => 'cpx'],
                ['label' => '{abc,cba} together because they use the same letters', 'next' => 'wrong_ana2'],
            ],
        ],
        'wrong_ana2' => [
            'message' => "You are wrong. Same letters are Group Anagrams, not a uniform shift. cba is not on the abc→bcd chain.\nStep back to when you sorted the word.",
            'outcome' => 'wrong',
            'rewind_to' => 'shift',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time and space O(L) for total characters. Not sorted-letter keys, not length-only, not Alien Dictionary edges.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Normalize first letter to a with wrap 26; hash the key; not Group Anagrams', 'next' => 'success'],
                ['label' => 'Missing Number XOR of 0..n, ignore the strings', 'next' => 'wrong_xor'],
            ],
        ],
        'wrong_xor' => [
            'message' => "You are wrong. XOR finds a missing index. This walk groups Caesar families.\nStep back to when you reused Missing Number.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Subtract s[0] so the first letter is a; add 26 if a char drops below a. Same key → same shift family. Store originals. Not sorted anagrams, not length-only.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
