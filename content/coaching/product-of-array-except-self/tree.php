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
            'message' => "Problem: answer[i] is the product of all nums[j] with j ≠ i. O(n) time, no division. [1,2,3,4] → [24,12,8,6]. [-1,1,0,-3,3] → [0,0,9,0,0]. Length 2 to 10⁵. Follow-up: O(1) extra besides answer.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Total product, then divide by nums[i]; or nested “times everything except i”', 'next' => 'div'],
                ['label' => 'Left-to-right prefix into ans, then right-to-left times a suffix accumulator', 'next' => 'pref'],
            ],
        ],
        'div' => [
            'message' => "Division is banned. Zeros also break a total/nums[i] plan. Nested loops are O(n²). Prefix sums add; this multiplies.\nHow do you stay O(n) without divide?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'left=1; for i: ans[i]=left, left times nums[i]. Then right=1 from the end: ans[i] times right, right times nums[i]', 'next' => 'pref'],
                ['label' => 'Count zeros: if two zeros all 0; if one zero only that index is the product of the rest — and still divide elsewhere', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong here.\nA zero-count special case still divides on the nonzero slots, which the problem forbids. The two-pass product never divides.\nStep back to when you counted zeros to divide.",
            'outcome' => 'wrong',
            'rewind_to' => 'div',
            'choices' => [],
        ],
        'pref' => [
            'message' => "After the left pass, ans[i] is the strict left prefix. The right pass folds the strict right suffix. One zero: every other index becomes 0; the zero’s index holds the product of the rest. Two zeros: the whole answer is 0.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2,3,4] → [24,12,8,6]; [-1,1,0,-3,3] → [0,0,9,0,0]', 'next' => 'cpx'],
                ['label' => 'Reuse a prefix-sum array and subtract nums[i] instead of multiplying prefixes', 'next' => 'wrong_sum'],
            ],
        ],
        'wrong_sum' => [
            'message' => "You are wrong. Prefix sums solve range addition. This is a product of all other entries, not a difference of sums.\nStep back to when you used prefix sums.",
            'outcome' => 'wrong',
            'rewind_to' => 'pref',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(1) extra besides ans. Not division, not O(n²), not prefix sums.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Prefix into ans, then suffix times; not divide, not nested, not prefix-sum', 'next' => 'success'],
                ['label' => 'Maximum Product Subarray (152) on the whole array and copy that scalar into every index', 'next' => 'wrong_152'],
            ],
        ],
        'wrong_152' => [
            'message' => "You are wrong. 152 finds one contiguous product. Here each index omits a different value.\nStep back to when you reused 152.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Fill ans with left prefixes, then multiply right suffixes in place. No division. O(n) / O(1) extra. Not nested loops, not prefix sums, not 152.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
