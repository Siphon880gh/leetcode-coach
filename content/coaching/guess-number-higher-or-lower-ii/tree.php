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
            'message' => "Problem: I pick in 1..n (n up to 200). A miss on x costs x dollars, then higher/lower and continue. Return the smallest bankroll that still wins no matter which number I picked. n=10 → 16. n=1 → 0. n=2 → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reuse 374: call guess() until you find the pick (or always guess the midpoint for cash)', 'next' => 'wrong_374'],
                ['label' => 'Minmax interval DP: f[i][j] is the min cash to guarantee a win on [i, j]', 'next' => 'dp'],
            ],
        ],
        'wrong_374' => [
            'message' => "You are wrong here. 374 finds the pick with an API. Here you must budget the worst remaining side. Midpoint-first is a strategy, not the optimum cash (n=10 wants 16, not a binary-search total).\nStep back to when you treated this as 374 or as binary-search cash.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dp' => [
            'message' => "f[i][i] = 0. For a longer range, try first guess k. Pay k, then take max(f[i][k−1], f[k+1][j]) for the costlier leftover. Minimize k plus that max. Empty leftover costs 0. Fill by increasing length so both sides are known. Seed with guess j first (j + f[i][j−1]), then try other k. Answer f[1][n].\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the sum of 1 through n, or fill f in an order that reads unsolved subranges', 'next' => 'wrong_sum'],
                ['label' => 'Increasing length, min over k of k plus the worse leftover', 'next' => 'kind'],
            ],
        ],
        'wrong_sum' => [
            'message' => "You are wrong. You never pay every integer. Reading a subrange before it is computed gives 0 or garbage.\nStep back to when you summed 1..n or filled in the wrong order.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'kind' => [
            'message' => "n=10’s writeup first-guesses 7, not 5. The first guess is chosen to minimize the worst leftover plus k, not to split the integers in half.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Interval minmax DP, O(n³). n=10 → 16. Not 374', 'next' => 'success'],
                ['label' => 'Always first-guess the midpoint of [i, j] and skip the min over k', 'next' => 'wrong_mid'],
            ],
        ],
        'wrong_mid' => [
            'message' => "You are wrong. Midpoint-first is not always cheapest. The DP must try every k.\nStep back to when you locked the first guess to the midpoint.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f[i][j] = min over k of k plus the worse leftover. n=10 → 16. Not 374.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
