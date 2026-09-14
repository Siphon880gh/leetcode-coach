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
            'message' => "Problem: s is lowercase, length 1 to 1e4. k is 1 to 1e5. Return the length of the longest substring where every letter in that substring appears at least k times. None exists → 0. aaabb, k=3 → 3 (aaa). ababbc, k=2 → 5 (ababb).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat this as Longest Substring Without Repeating (3), or At Most K Distinct (340)', 'next' => 'wrong_340'],
                ['label' => 'Count letters in the current segment; letters below k become split walls', 'next' => 'split'],
            ],
        ],
        'wrong_340' => [
            'message' => "You are wrong here. 3 bans repeats. 340 caps how many distinct letters you may keep. Here a letter may repeat a lot — it just cannot appear 1..k-1 times inside the chosen window.\nStep back to when you used 3 or 340.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'split' => [
            'message' => "Count the current [L, R]. If every present letter already has count at least k, this whole piece is valid — return its length. Else pick a rare letter (count in 1..k-1) and split the segment on that letter; recurse on the maximal pieces that contain none of it; take the max.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the whole string even when some letter in it appears fewer than k times', 'next' => 'wrong_whole'],
                ['label' => 'A rare letter cannot sit in any valid piece; search only the gaps between its hits', 'next' => 'kind'],
            ],
        ],
        'wrong_whole' => [
            'message' => "You are wrong. aaabb with k=3 has two b's, so the full string is invalid. The answer is 3 from aaa, found after splitting on b.\nStep back to when you kept a rare letter inside the window.",
            'outcome' => 'wrong',
            'rewind_to' => 'split',
            'choices' => [],
        ],
        'kind' => [
            'message' => "If k is bigger than the segment length, that piece is 0. A sliding window that enumerates how many distinct letters the window is allowed (1..26) also works; the split is the divide-and-conquer form.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Split on rare letters. aaabb, k=3 → 3. Not 340', 'next' => 'success'],
                ['label' => 'Only keep a run of one letter, or require every letter of the alphabet to hit k', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. ababbc with k=2 answers 5 (ababb): two letters, each at least twice. Missing letters of the alphabet do not matter — only letters that appear in the substring.\nStep back to when you forced a single-letter run or required unused letters.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Split on letters whose count is below k. aaabb, k=3 → 3. ababbc, k=2 → 5. Not 340.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
