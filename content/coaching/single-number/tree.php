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
            'message' => "Problem: every value appears twice except one. Return that single. Linear time and O(1) extra space. [2,2,1] → 1. [4,1,2,1,2] → 4. [1] → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A hash set of leftovers, sort then scan, Candy’s two slopes, or Gray code’s i XOR (i>>1) as the answer', 'next' => 'hash'],
                ['label' => 'XOR every nums[i] into ans starting at 0', 'next' => 'xor'],
            ],
        ],
        'hash' => [
            'message' => "A set of unpaired values is O(n) extra. Sort is O(n log n). Candy and Gray code are different problems.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count frequencies in a map, or treat this as Single Number II (triples)', 'next' => 'wrong_other'],
                ['label' => 'x XOR x is 0 and x XOR 0 is x, so pairs vanish and the leftover is the answer', 'next' => 'xor'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nA map is extra O(n) space. Single Number II is “appears three times,” not twice.\nStep back to when you copied those tools.",
            'outcome' => 'wrong',
            'rewind_to' => 'hash',
            'choices' => [],
        ],
        'xor' => [
            'message' => "ans = 0; for v in nums: ans ^= v. Order does not matter because XOR is associative and commutative.\nWhy start at 0?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '0 is the identity: XOR with 0 leaves the running value unchanged until the first number', 'next' => 'ret'],
                ['label' => 'You must start at nums[0] and skip index 0, otherwise 0 would wipe the answer', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. XOR with 0 does not wipe a value. Starting at 0 or at nums[0] both work; 0 is just the identity.\nStep back to when you feared 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'xor',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(n), extra O(1). [4,1,2,1,2] folds to 4. A lone [1] is already 1.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The final ans after XOR-ing the whole array', 'next' => 'success'],
                ['label' => 'The count of values that appeared once, not the value itself', 'next' => 'wrong_count'],
            ],
        ],
        'wrong_count' => [
            'message' => "You are wrong. The return type is the unpaired integer, not how many singles exist (there is exactly one).\nStep back to when you returned a count.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. XOR everything. Pairs cancel. Time O(n), extra O(1). Not a hash set, not sort, not Candy, not Gray code, not Single Number II.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
