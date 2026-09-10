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
            'message' => "Problem: distinct positives nums (n up to 200) and target up to 1000. Count sequences that sum to target. Order matters: [1,2,3], target 4 → 7 because (1,3) and (3,1) both count. [9], target 3 → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Combination Sum (39) DFS of unique sets, or Coin Change (322) fewest coins', 'next' => 'wrong_39'],
                ['label' => 'DP: f[i] is the number of sequences that sum to i; f[0] = 1', 'next' => 'dp'],
            ],
        ],
        'wrong_39' => [
            'message' => "You are wrong here. 39 lists sets (order ignored). 322 wants the fewest coins, not a count of sequences.\nStep back to when you treated this as 39 or 322.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dp' => [
            'message' => "For i from 1 to target, for each x in nums, if i ≥ x add f[i − x]. The last step x can follow any sequence for i − x, so rearrangements count separately.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Loop coins outside and sums inside (Coin Change II / 518 combinations)', 'next' => 'wrong_518'],
                ['label' => 'Loop the target outside the coins so order is a permutation', 'next' => 'kind'],
            ],
        ],
        'wrong_518' => [
            'message' => "You are wrong. Coins-outside counts each multiset once. Then [1,2,3] target 4 would not be 7.\nStep back to when you used the 518 loop order.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Do not sort-and-skip as in Combination Sum II. Negatives (follow-up) can loop forever unless you bound length. Watch 32-bit overflow when adding f[i − x].\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Permutation knapsack, target outer. [1,2,3] target 4 → 7. Not 39. Not 518', 'next' => 'success'],
                ['label' => 'Return 1 for that example, or skip duplicate sequences after sorting nums', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. Seven sequences are listed in the writeup. Skipping “duplicates” is the set version.\nStep back to when you collapsed orders.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f[i] += f[i − x] with the sum loop outside. [1,2,3] target 4 → 7. Not 39. Not 322. Not 518.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
