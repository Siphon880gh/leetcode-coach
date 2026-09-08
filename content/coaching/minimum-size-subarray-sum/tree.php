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
            'message' => "Problem: positive nums, positive target. Shortest contiguous subarray whose sum is at least target. None → 0. target 7, [2,3,1,2,4,3] → 2 ([4,3]). [1,4,4] vs 4 → 1. Eight 1s vs 11 → 0. n up to 10⁵.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nested every left/right pair and sum the slice each time', 'next' => 'nested'],
                ['label' => 'Grow r into a running sum; while sum ≥ target, record r−l+1 and drop nums[l]', 'next' => 'window'],
            ],
        ],
        'nested' => [
            'message' => "O(n²) sums time out at 10⁵. Minimum Window Substring covers a letter multiset, not a numeric threshold. A trie stores prefixes of words, not subarray sums.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Each node: 26 children plus isEnd; search needs the path and isEnd', 'next' => 'wrong_trie'],
                ['label' => 'Every value is ≥ 1, so the window is monotone: grow r, keep shrinking l while the sum is enough', 'next' => 'window'],
            ],
        ],
        'wrong_trie' => [
            'message' => "You are wrong here.\nA trie is Implement Trie. This is a positive-sum window.\nStep back to when you reused a prefix tree.",
            'outcome' => 'wrong',
            'rewind_to' => 'nested',
            'choices' => [],
        ],
        'window' => [
            'message' => "l = 0, s = 0, ans = n+1. For each r: s += nums[r]. While s ≥ target: ans = min(ans, r−l+1), s -= nums[l], l += 1. After the scan, if ans never updated return 0. Keep shrinking so [2,3,1,2] of sum 8 is length 4, then [4,3] of length 2 wins. Prefix plus binary search is the O(n log n) twin.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '7 with [2,3,1,2,4,3] is 2; 4 with [1,4,4] is 1; 11 with eight 1s is 0', 'next' => 'cpx'],
                ['label' => 'Return the subarray itself; 0 means empty list', 'next' => 'wrong_ret'],
            ],
        ],
        'wrong_ret' => [
            'message' => "You are wrong. The judge wants the length, not the slice. Impossible is integer 0, not [].\nStep back to when you returned the window.",
            'outcome' => 'wrong',
            'rewind_to' => 'window',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Window: O(n) time, O(1) extra. Prefix plus binary search: O(n log n) time, O(n) prefixes. Return a length.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Grow r, shrink while enough, min length or 0; not nested pairs, not a trie, not the slice', 'next' => 'success'],
                ['label' => 'Shrink l at most once per r; later shorter windows cannot beat an earlier long one', 'next' => 'wrong_once'],
            ],
        ],
        'wrong_once' => [
            'message' => "You are wrong. Keep shrinking while the sum stays ≥ target. One shrink leaves a longer window that later [4,3] must still beat — but you must still try every feasible left edge.\nStep back to when you shrunk only once.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Positive nums make the window monotone. Grow r, keep shrinking l while the sum is enough, track min length, else 0. O(n). Prefix plus binary search is the slower twin. Not nested pairs, not a trie, not returning the slice.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
