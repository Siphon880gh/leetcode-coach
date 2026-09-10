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
            'message' => "Problem: rearrange s so two equal letters are at least k positions apart, or return empty. aabbcc with k = 3 → abcabc. aaabc with k = 3 → empty. Length up to 3×10^5. k = 0 means no gap rule.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DFS / backtrack every permutation of s', 'next' => 'wrong_bt'],
                ['label' => 'Count letters. Always place the remaining most-frequent one; cooldown of k', 'next' => 'heap'],
            ],
        ],
        'wrong_bt' => [
            'message' => "You are wrong here. n is 3×10^5. Searching permutations will not finish.\nStep back to when you backtracked.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'heap' => [
            'message' => "Max-heap of leftover counts. Pop, append that letter, push the decremented count into a queue. When the queue length is at least k, the front may return to the heap if it still has copies.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'If the heap empties while the answer is shorter than s, leftover copies are stuck too close — return empty', 'next' => 'kind'],
                ['label' => 'Sort the unique letters once and round-robin them without a cooldown queue', 'next' => 'wrong_rr'],
            ],
        ],
        'wrong_rr' => [
            'message' => "You are wrong. A later burst of one letter can still sit closer than k if you do not wait after each placement.\nStep back to when you skipped the cooldown.",
            'outcome' => 'wrong',
            'rewind_to' => 'heap',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Reorganize String (767) is this problem with k = 2. Impossible means empty, not a partial string. k = 0 lets a letter return to the heap immediately.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Greedy heap plus cooldown k. Empty if the heap dies early. 767 is k = 2', 'next' => 'success'],
                ['label' => 'Return the partial answer when the heap is empty, or treat 767 as a different layout', 'next' => 'wrong_part'],
            ],
        ],
        'wrong_part' => [
            'message' => "You are wrong. A short answer means some copies never found a legal slot. Return empty, not a prefix.\nStep back to when you kept a partial string.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Place the current most-frequent leftover, then wait k before reuse. Heap empty before length n → empty. aabbcc, k = 3 → abcabc. Not backtracking.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
