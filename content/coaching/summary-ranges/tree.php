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
            'message' => "Problem: sorted unique nums. Smallest list of inclusive ranges covering exactly those values, as strings. \"a->b\" if a ≠ b, else \"a\". Length 0..20. Empty → []. [0,1,2,4,5,7] → [\"0->2\",\"4->5\",\"7\"]. [0,2,3,4,6,8,9] → [\"0\",\"2->4\",\"6\",\"8->9\"].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Merge Intervals on [start,end] pairs, or Missing Ranges (163) to emit the holes', 'next' => 'wrongish'],
                ['label' => 'Two pointers: from i grow j while nums[j+1] equals nums[j] plus 1, then format [i,j]', 'next' => 'walk'],
            ],
        ],
        'wrongish' => [
            'message' => "Merge Intervals unions overlapping intervals you are given. Missing Ranges prints the gaps. Here nums is already sorted and unique; you only glue consecutive plus-ones.\nHow do you emit a run?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'i = 0. j starts at i. Grow j while the next value is plus one. One index → str(nums[i]); else nums[i]->nums[j]. Then i = j+1', 'next' => 'walk'],
                ['label' => 'Join any pair whose difference is at most 2 so 0 and 2 become 0->2', 'next' => 'wrong_gap'],
            ],
        ],
        'wrong_gap' => [
            'message' => "You are wrong here.\nA gap of 2 means 1 is missing, so 0 and 2 stay separate ranges.\nStep back to when you joined across a hole.",
            'outcome' => 'wrong',
            'rewind_to' => 'wrongish',
            'choices' => [],
        ],
        'walk' => [
            'message' => "Use the arrow -> not a hyphen (a hyphen looks like a negative). Do not invent integers that are not in nums. Empty input is [].\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[0,1,2,4,5,7] → [\"0->2\",\"4->5\",\"7\"]; [0,2,3,4,6,8,9] → [\"0\",\"2->4\",\"6\",\"8->9\"]', 'next' => 'cpx'],
                ['label' => 'Format every run as a->b even when a equals b, so a singleton is \"7->7\"', 'next' => 'wrong_fmt'],
            ],
        ],
        'wrong_fmt' => [
            'message' => "You are wrong. When i equals j the output is just \"a\", not \"a->a\".\nStep back to when you always printed the arrow.",
            'outcome' => 'wrong',
            'rewind_to' => 'walk',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(1) extra besides the answer. One pass. Not Merge Intervals, not Missing Ranges.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Grow while plus one; not Merge Intervals, not holes, not gap-2 joins, not a->a for singletons', 'next' => 'success'],
                ['label' => 'Insert the missing integers so each range is a dense interval in the output list', 'next' => 'wrong_fill'],
            ],
        ],
        'wrong_fill' => [
            'message' => "You are wrong. Ranges cover nums exactly — no integer in a range that is not in nums.\nStep back to when you filled holes.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. From each i grow j while the next value is plus one. Format \"a\" or \"a->b\". O(n). Not Merge Intervals, not Missing Ranges, not joining a gap of 2, not \"a->a\".\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
