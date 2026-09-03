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
            'message' => "Problem: nums is sorted and unique inside [lower, upper]. Return the shortest list of inclusive ranges that cover every missing integer. [0,1,3,50,75], 0..99 → [[2,2],[4,49],[51,74],[76,99]]. [-1] with bounds -1..-1 → [].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Find Peak, Merge Intervals, or string ranges of the numbers that are present', 'next' => 'merge'],
                ['label' => 'Empty nums → [[lower, upper]]; else emit the hole before, between, and after', 'next' => 'scan'],
            ],
        ],
        'merge' => [
            'message' => "You are listing absences, not merging overlaps and not describing the values that already sit in nums. Find Peak is binary search on a slope.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return one range [lower, upper] even when nums already fills the bounds', 'next' => 'wrong_all'],
                ['label' => 'If nums[0] > lower, emit [lower, nums[0]-1]; pairwise emit [a+1, b-1] when b-a > 1; then a tail past nums[-1]', 'next' => 'scan'],
            ],
        ],
        'wrong_all' => [
            'message' => "You are wrong here.\n[-1] with lower = upper = -1 has no missing numbers, so []. Covering the whole interval would include nums.\nStep back to when you ignored the filled bounds.",
            'outcome' => 'wrong',
            'rewind_to' => 'merge',
            'choices' => [],
        ],
        'scan' => [
            'message' => "Empty nums is the one full range. Consecutive values (b-a == 1) emit nothing. A single missing integer is [x, x], not skipped.\nOn [0,1,3,50,75] with 0..99, what is the first emitted range?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[2,2] — 0 and 1 sit at the start, then 2 is missing before 3', 'next' => 'ans'],
                ['label' => '[0,99] or [4,49] as if 2 were not a range of its own', 'next' => 'wrong_first'],
            ],
        ],
        'wrong_first' => [
            'message' => "You are wrong. The first hole is just 2. [4,49] comes after 3. Do not dump the whole [0,99].\nStep back to when you named the first range.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'ans' => [
            'message' => "Then [4,49], [51,74], and [76,99] because 75 < 99. Time O(n). Not Find Peak, not Merge Intervals.\nWhat is nums = [-1], lower = -1, upper = -1?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[] — nothing missing', 'next' => 'success'],
                ['label' => '[[-1,-1]] or the four ranges from the other sample', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. The only value in bounds is already in nums, so the answer is empty. Do not reuse the 0..99 sample.\nStep back to when you scored the singleton.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Prefix hole, interior pairwise holes, suffix hole. Empty nums → one range. Consecutive nums emit nothing. Not Find Peak, not Merge Intervals, not ranges of present values. [0,1,3,50,75] with 0..99 → [[2,2],[4,49],[51,74],[76,99]].\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
