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
            'message' => "Problem: sorted nums; min patches so every integer in [1, n] is a subset sum. [1,3], n=6 → 1 (patch 2). [1,2,2], n=5 → 0. n up to 2³¹−1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Coin Change (322) DP, or patch a value larger than the hole', 'next' => 'wrong_coin'],
                ['label' => 'x = smallest uncovered; take nums[i] if ≤ x, else patch x and double', 'next' => 'greedy'],
            ],
        ],
        'wrong_coin' => [
            'message' => "You are wrong here.\n322 uses unlimited copies of given coins. Here each array value is used at most once, and you may insert new numbers. Patching bigger than x leaves a hole at x.\nStep back to when you used coin-change DP or patched past the hole.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'greedy' => [
            'message' => "x starts at 1 ([1, x−1] empty). While x ≤ n (64-bit x): if i is in range and nums[i] ≤ x, x += nums[i], i += 1; else ans += 1 and double x. Adding x is best because the new uncovered start is 2x.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '32-bit x (overflow when doubling), or skip unused nums[i] forever', 'next' => 'wrong_ov'],
                ['label' => 'O(m + log n). Stop when x exceeds n', 'next' => 'cpx'],
            ],
        ],
        'wrong_ov' => [
            'message' => "You are wrong. n is up to 2³¹−1; doubling x can exceed a 32-bit int. A later nums[i] still helps if it is ≤ the current x.\nStep back to when you overflowed x or ignored remaining nums.",
            'outcome' => 'wrong',
            'rewind_to' => 'greedy',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "The answer is the patch count, not the patched values.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Cover [1, x−1], consume or double. 64-bit. Not 322', 'next' => 'success'],
                ['label' => 'Return the patched numbers instead of how many you added', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. The judge wants the minimum number of patches, not the list of values.\nStep back to when you returned the patches themselves.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Covered prefix [1, x−1]; take nums[i] if it is ≤ x, else patch x and double. 64-bit x. Not coin change.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
