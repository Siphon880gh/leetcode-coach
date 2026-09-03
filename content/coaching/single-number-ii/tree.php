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
            'message' => "Problem: every value appears three times except one that appears once. Return that one. Linear time, O(1) extra space. [2,2,3,2] → 3. [0,1,0,1,0,1,99] → 99.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'XOR the whole array like Single Number I, a frequency map, or Gray code’s i XOR (i>>1)', 'next' => 'xor1'],
                ['label' => 'For each of 32 bits, count how many nums have that bit; if count % 3 ≠ 0, set that bit on ans', 'next' => 'bits'],
            ],
        ],
        'xor1' => [
            'message' => "x XOR x XOR x is x, so triples do not cancel. A map is extra O(n) space. Gray code is a different sequence.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Candy’s two slopes, or (3 times the unique-sum minus total) / 2 with a set', 'next' => 'wrong_other'],
                ['label' => 'Bits of triples contribute multiples of 3; leftover 1s on a bit belong to the singleton', 'next' => 'bits'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nA set of uniques is extra space. Candy is neighbor ratings, not bits.\nStep back to when you copied those tools.",
            'outcome' => 'wrong',
            'rewind_to' => 'xor1',
            'choices' => [],
        ],
        'bits' => [
            'message' => "cnt = sum of (num >> i) & 1 over nums. If cnt % 3, ans |= 1 << i (Python: bit 31 is the sign, subtract 1<<31).\nWhy % 3 and not % 2?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Each triple adds 0 or 3 to the bit count; % 3 leaves only the singleton’s 0 or 1', 'next' => 'ret'],
                ['label' => '% 2 is XOR, which already worked in Single Number I, so it still works here', 'next' => 'wrong_mod'],
            ],
        ],
        'wrong_mod' => [
            'message' => "You are wrong. % 2 cannot tell 3 ones from 1 one. That is why XOR-all fails on triples.\nStep back to when you reused % 2.",
            'outcome' => 'wrong',
            'rewind_to' => 'bits',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(32 n), extra O(1). [2,2,3,2] leaves bit 0 and bit 1 of 3. Return ans, not the counts.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'ans after OR-ing every bit whose count is not divisible by 3', 'next' => 'success'],
                ['label' => 'The first count % 3 that is nonzero, as if the answer were a bit index', 'next' => 'wrong_idx'],
            ],
        ],
        'wrong_idx' => [
            'message' => "You are wrong. The answer is the reconstructed integer, not which bit you noticed first.\nStep back to when you returned a bit index.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Per-bit counts modulo 3 rebuild the singleton. Time O(n), extra O(1). Not XOR-all (Single Number I), not a map, not a set formula, not Candy, not Gray code.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
