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
            'message' => "Problem: ransomNote and magazine are lowercase, lengths up to 1e5. Return true iff you can build the note using letters from the magazine, each magazine letter at most once. a / b → false. aa / ab → false. aa / aab → true.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Require the two strings to be anagrams (242), or scan magazine from scratch for every note letter', 'next' => 'wrong_ana'],
                ['label' => 'Count magazine, then spend those counts while walking the note', 'next' => 'cnt'],
            ],
        ],
        'wrong_ana' => [
            'message' => "You are wrong here. Valid Anagram needs equal counts both ways. Magazine may have leftover letters. Rescanning magazine per note letter is O(m n) at 1e5.\nStep back to when you used 242 or nested scans.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'cnt' => [
            'message' => "Counter(magazine), or a 26-slot array. For each letter in ransomNote, decrement. If a count drops below 0, return false. If the walk finishes, return true. Counting the note first and checking needs against magazine is the same idea.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reuse a magazine letter, or require the two strings to have the same length', 'next' => 'wrong_len'],
                ['label' => 'Each magazine letter is used at most once; extra magazine letters are fine', 'next' => 'kind'],
            ],
        ],
        'wrong_len' => [
            'message' => "You are wrong. aa / aab is true even though magazine is longer. You cannot spend the same magazine a twice for aa / ab.\nStep back to when you reused a letter or demanded equal length.",
            'outcome' => 'wrong',
            'rewind_to' => 'cnt',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Sorting both and two-pointer matching works but is n log n. Group Anagrams (49) clusters many strings; here there are only two.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Cover, not anagram. aa / aab → true. Not 242', 'next' => 'success'],
                ['label' => 'Return true for aa / ab, or false for aa / aab because lengths differ', 'next' => 'wrong_ex'],
            ],
        ],
        'wrong_ex' => [
            'message' => "You are wrong. aa / ab is false (only one a). aa / aab is true (two a’s plus a leftover b).\nStep back to when you flipped those examples.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Count magazine, spend on the note, fail on a negative count. Cover, not anagram. Not 242.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
