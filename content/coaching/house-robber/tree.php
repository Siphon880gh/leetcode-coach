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
            'message' => "Problem: houses in a line, nums[i] is cash. Rob a subset with no two adjacent. Max total. [1,2,3,1] → 4. [2,7,9,3,1] → 12. One house → that house.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always take the local max, or always take even indices then compare odd indices', 'next' => 'greedy'],
                ['label' => 'Linear DP: skip this house or take it plus the best from two houses back', 'next' => 'dp'],
            ],
        ],
        'greedy' => [
            'message' => "Peaks lose: 2, 7, 9 wants 2+9, not 7. Even/odd misses 2+9+1 on [2,7,9,3,1]. House Robber II is a circle; this street is a line.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat the street as a circle and skip first and last together', 'next' => 'wrong_circle'],
                ['label' => 'f(i) = max(f(i-1), f(i-2) plus nums[i-1]); answer f(n)', 'next' => 'dp'],
            ],
        ],
        'wrong_circle' => [
            'message' => "You are wrong here.\nCircle wrapping is House Robber II. Here first and last may both be taken if they are not adjacent on a line of length ≥ 3.\nStep back to when you wrapped the street.",
            'outcome' => 'wrong',
            'rewind_to' => 'greedy',
            'choices' => [],
        ],
        'dp' => [
            'message' => "f(0)=0, f(1)=nums[0]. For i>1: skip house i-1 → f(i-1); rob it → f(i-2) plus nums[i-1]. Roll two integers prev2, prev1.\nWhich sample totals?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2,3,1] is 4; [2,7,9,3,1] is 12 (2, 9, and 1)', 'next' => 'cpx'],
                ['label' => '[1,2,3,1] is 3 (2+1) or [2,7,9,3,1] is 16 (take every house)', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Adjacent houses cannot both be robbed, so 2+1 on the first sample loses to 1+3. Taking every house on the second is illegal.\nStep back to when you scored the samples.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n). Space O(1) rolling, or O(n) if you store the whole f array. Uncached recursion is exponential.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip or take-plus-two-back; not greedy peaks, not House Robber II', 'next' => 'success'],
                ['label' => 'Must store every f[i] forever; rolling two integers is illegal', 'next' => 'wrong_roll'],
            ],
        ],
        'wrong_roll' => [
            'message' => "You are wrong. Only the last two f values feed the next, so two integers are enough.\nStep back to when you banned rolling.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Adjacent houses are banned. f(i) = max(skip, take plus two back). Roll two integers. O(n) / O(1). Not greedy peaks, not even/odd only, not the circle variant.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
