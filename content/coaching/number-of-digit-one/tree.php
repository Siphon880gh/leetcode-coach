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
            'message' => "Problem: count how many times decimal digit 1 appears in all integers from 0 through n. 0 ≤ n ≤ 10⁹. 13 → 6 (1, 10, 11 twice, 12, 13). 0 → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Loop 1..n and count 1s, or Number of 1 Bits (191) on n’s binary form', 'next' => 'wrongish'],
                ['label' => 'Digit DP: dfs(i, cnt, limit) over digits of n; bump cnt when the chosen digit is 1', 'next' => 'dp'],
            ],
        ],
        'wrongish' => [
            'message' => "A scan to n is O(n) and dies at a billion. 191 counts binary 1s of one integer, not decimal 1s in a range.\nHow do you stay O(digits)?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 's = str(n). At pos i, j from 0 to up (s[i] if still tight, else 9). Recurse with cnt+(j==1) and limit and j==up', 'next' => 'dp'],
                ['label' => 'Count 11 as a single 1 because it is one number', 'next' => 'wrong_11'],
            ],
        ],
        'wrong_11' => [
            'message' => "You are wrong here.\n11 contributes two digit-1s. The sample 13 → 6 includes both.\nStep back to when you undercounted 11.",
            'outcome' => 'wrong',
            'rewind_to' => 'wrongish',
            'choices' => [],
        ],
        'dp' => [
            'message' => "Past the last digit, return cnt. Leading zeros are digit 0 (no extra 1s). Cache (i, cnt) when limit is false so suffixes off the bound are reused. Do not cache the tight prefix as if it were free of n.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '13 → 6; 0 → 0', 'next' => 'cpx'],
                ['label' => 'Memoize every (i, cnt) even while still matching n’s prefix', 'next' => 'wrong_memo'],
            ],
        ],
        'wrong_memo' => [
            'message' => "You are wrong. While limit is true the remaining digits still depend on n. Caching that as a free suffix mixes bounds.\nStep back to when you memoized the tight path.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(m² · 10) with m ≤ 10 digits. Place-wise math (1s in tens, hundreds, …) is the same count. Not 191, not a loop to n.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Digit DP on decimal 1s; not 191, not scanning n, not counting 11 once, not memoizing the tight prefix', 'next' => 'success'],
                ['label' => 'Plus One on the digit array of n and return that length', 'next' => 'wrong_plus'],
            ],
        ],
        'wrong_plus' => [
            'message' => "You are wrong. Plus One mutates one number. This problem totals the digit 1 across a range.\nStep back to when you used Plus One.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Digit DP: at each place choose 0..up, add 1 to cnt when j is 1, keep limit only when still tight. 11 counts twice. O(m²). Not 191, not a loop to n, not Plus One.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
