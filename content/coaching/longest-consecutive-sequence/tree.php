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
            'message' => "Problem: longest consecutive value run in an unsorted array, in O(n). [100,4,200,1,3,2] → 4 (1..4). [0,3,7,2,5,8,4,6,0,1] → 9. [1,0,1,2] → 3. Empty → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort then scan (O(n log n)), Longest Increasing Subsequence, or Maximum Subarray’s index window', 'next' => 'sort'],
                ['label' => 'Put every number in a set; only walk forward from values that have no predecessor', 'next' => 'set'],
            ],
        ],
        'sort' => [
            'message' => "Sort is too slow for the O(n) bound. LIS is increasing, not consecutive. Max Subarray cares about index adjacency, not 1,2,3,4 sitting at scattered indices.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Word Ladder’s BFS on strings, or Union-Find with an explicit parent array of size 2e9', 'next' => 'wrong_other'],
                ['label' => 's = set(nums); for x in s: if x-1 not in s, count x, x+1, x+2, … until a gap', 'next' => 'set'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nWord Ladder is a string graph. You cannot allocate a parent array over 1e9 values. The set already stores the n numbers.\nStep back to when you copied those tools.",
            'outcome' => 'wrong',
            'rewind_to' => 'sort',
            'choices' => [],
        ],
        'set' => [
            'message' => "Each number is expanded at most once, so O(n) time and O(n) space. Duplicates collapse in the set, so [1,0,1,2] is still 3.\nWhy skip x when x-1 is already in the set?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'That x is the middle of a longer run; starting there would recount a suffix and miss the true start', 'next' => 'ret'],
                ['label' => 'Start a run at every x; nested while loops are still O(n²) and that is required', 'next' => 'wrong_every'],
            ],
        ],
        'wrong_every' => [
            'message' => "You are wrong. Starting at every x can be quadratic (a long run of n). The O(n) trick is: only begin at a number with no left neighbor.\nStep back to when you started a run at every value.",
            'outcome' => 'wrong',
            'rewind_to' => 'set',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return the integer length, not the slice [1,2,3,4]. Empty input is 0.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '4, 9, and 3 on the samples — not the list of values and not a boolean', 'next' => 'success'],
                ['label' => 'The sequence [1, 2, 3, 4]', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. The judge wants the length, not the numbers in the run.\nStep back to when you returned a list.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Hash set. Start a streak only if x-1 is missing. Count forward. O(n) / O(n). Not sort, not LIS, not Max Subarray, not Word Ladder, not returning the values.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
