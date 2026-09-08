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
            'message' => "Problem: right-rotate nums by k steps in place. [1,2,3,4,5,6,7], k = 3 → [5,6,7,1,2,3,4]. [-1,-100,3,99], k = 2 → [3,99,-1,-100]. n up to 1e5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Rotate List’s k-gap on a linked list, or Rotate Image’s row reverse plus transpose', 'next' => 'other'],
                ['label' => 'k %= n, reverse the whole array, reverse the first k, reverse the rest', 'next' => 'rev'],
            ],
        ],
        'other' => [
            'message' => "This is an array, not a list cut or an n by n matrix. Reverse Words II already used two-pointer reverse on a buffer.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Shift right by 1, k times', 'next' => 'wrong_shift'],
                ['label' => 'Three reverses after k modulo n', 'next' => 'rev'],
            ],
        ],
        'wrong_shift' => [
            'message' => "You are wrong here.\nk times a full shift is O(n k) and times out at 1e5.\nStep back to when you shifted one cell at a time.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'rev' => [
            'message' => "[1,2,3,4,5,6,7], k = 3: whole → [7,6,5,4,3,2,1]; first 3 → [5,6,7,4,3,2,1]; rest → [5,6,7,1,2,3,4]. Extra-array twin: write to (i + k) % n.\nIf k becomes 0 after modulo?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'First reverse and last reverse cancel — already the original', 'next' => 'cpx'],
                ['label' => 'You still need to swap the two halves', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. k = 0 is a no-op. The two full reverses undo each other if you still reverse first-0 (empty) and the rest (the whole array again).\nStep back to when you treated k = 0 as a half-swap.",
            'outcome' => 'wrong',
            'rewind_to' => 'rev',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Follow-up is O(1) extra, not a second array. Time O(n).\nWhat is the sample after rotate by 3?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[5,6,7,1,2,3,4]', 'next' => 'success'],
                ['label' => '[3,4,5,6,7,1,2] (left rotate) or [7,6,5,4,3,2,1]', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Right rotate by 3 puts the last three in front, letters not reversed.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. k %= n. Reverse all, reverse first k, reverse the rest. O(n) / O(1). Not Rotate List, not Rotate Image, not k single shifts.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
