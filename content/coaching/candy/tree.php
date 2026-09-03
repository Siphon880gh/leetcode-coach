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
            'message' => "Problem: n children in a line. Each gets at least 1 candy. A strictly higher rating than a neighbor must get strictly more candies than that neighbor. Return the minimum total. [1,0,2] → 5 (2,1,2). [1,2,2] → 4 (1,2,1). n up to 5e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Give ratings[i] candies, Gas Station’s tank reset, or one left-to-right pass that only beats the left neighbor', 'next' => 'oneway'],
                ['label' => 'Two arrays init to 1: left pass vs i-1, right pass vs i+1, then sum max(left[i], right[i])', 'next' => 'two'],
            ],
        ],
        'oneway' => [
            'message' => "A peak must beat both sides. One LTR pass on [1,0,2] can leave the last child with 1 while the left slope already used 2,1 — the right constraint is missing. Ratings as counts overspend.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Trapping Rain Water’s min(left max, right max), or force equal ratings to differ by 1 candy', 'next' => 'wrong_other'],
                ['label' => 'Independent left and right slopes, then the candy at i is max of the two', 'next' => 'two'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nRain water mins two height maxima. Equal ratings may share a candy count — sample [1,2,2] ends 1,2,1.\nStep back to when you copied those rules.",
            'outcome' => 'wrong',
            'rewind_to' => 'oneway',
            'choices' => [],
        ],
        'two' => [
            'message' => "left[i]=1, and if ratings[i] > ratings[i-1] then left[i]=left[i-1]+1. Mirror from the right into right[i]. Equals do not bump.\nWhy take max, not sum or min?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'max meets both neighbor inequalities at once with the fewest candies', 'next' => 'ret'],
                ['label' => 'sum the two arrays, because left candies and right candies are separate piles', 'next' => 'wrong_sum'],
            ],
        ],
        'wrong_sum' => [
            'message' => "You are wrong. Each child gets one pile. left and right are lower bounds on that same pile, so you take the max.\nStep back to when you added the two arrays.",
            'outcome' => 'wrong',
            'rewind_to' => 'two',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(n), extra O(n). [1,0,2] → max pairs (1,2),(1,1),(2,1) → 2+1+2=5. [1,2,2] → 1+2+1=4.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The sum of max(left[i], right[i]) — the minimum candies, not the assignment array', 'next' => 'success'],
                ['label' => 'The left array alone, since the right pass is only a check', 'next' => 'wrong_left'],
            ],
        ],
        'wrong_left' => [
            'message' => "You are wrong. Returning only left ignores the right-neighbor rule. Both passes feed the max.\nStep back to when you dropped the right array.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Two 1-initialized slopes, bump only on a strictly higher rating, sum the per-index max. Time O(n), extra O(n). Equals may match. Not Gas Station, not rain-water min, not ratings-as-counts, not one LTR pass.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
