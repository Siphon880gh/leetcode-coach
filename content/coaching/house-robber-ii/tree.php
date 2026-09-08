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
            'message' => "Problem: houses in a circle — first and last are neighbors. nums[i] is cash; no two adjacent (including the wrap). Max total. [2,3,2] → 3. [1,2,3,1] → 4. [1,2,3] → 3. One house → that house.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Run linear House Robber on the whole array; first and last may both be taken', 'next' => 'line'],
                ['label' => 'Two linear runs: drop last, drop first; take the max. One house is nums[0]', 'next' => 'two'],
            ],
        ],
        'line' => [
            'message' => "On a line, [2,3,2] could take both 2s. Here they wrap, so the answer is 3. Digit DP counts decimal 1s up to n — unrelated. House Robber I is the helper, not the whole answer.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'dfs digits of n; bump cnt when the digit is 1', 'next' => 'wrong_digit'],
                ['label' => 'You cannot rob both ends, so max(rob[0..n−2], rob[1..n−1]); n==1 returns nums[0]', 'next' => 'two'],
            ],
        ],
        'wrong_digit' => [
            'message' => "You are wrong here.\nNumber of Digit One is digit DP. This is circular House Robber.\nStep back to when you reused digit DP.",
            'outcome' => 'wrong',
            'rewind_to' => 'line',
            'choices' => [],
        ],
        'two' => [
            'message' => "Linear helper: skip or take-plus-two-back, roll two integers. Range A is all but the last house. Range B is all but the first. Answer max(A, B). Do not add nums[0] plus nums[n−1].\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[2,3,2] is 3; [1,2,3,1] is 4; [1,2,3] is 3; a single house is itself', 'next' => 'cpx'],
                ['label' => '[2,3,2] is 4 because both end 2s are far apart on a circle', 'next' => 'wrong_wrap'],
            ],
        ],
        'wrong_wrap' => [
            'message' => "You are wrong. On a circle the two 2s are adjacent. You may take only the middle 3.\nStep back to when you robbed both ends.",
            'outcome' => 'wrong',
            'rewind_to' => 'two',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n). Space O(1). Two passes of the linear helper.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Max of skip-first and skip-last; not one linear pass on all n, not digit DP, not both ends', 'next' => 'success'],
                ['label' => 'Always add the first house to the linear answer of the rest', 'next' => 'wrong_add'],
            ],
        ],
        'wrong_add' => [
            'message' => "You are wrong. Forcing nums[0] into the take set can beat a better skip-first plan, and it still has to drop the last house.\nStep back to when you always took the first house.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Circle → cannot take both ends. Linear House Robber on [0..n−2] and [1..n−1]; max. One house is nums[0]. O(n) / O(1). Not a single line DP on all n, not digit DP, not both wrap-around 2s.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
