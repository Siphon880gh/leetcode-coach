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
            'message' => "Problem: the majority value appears more than n/2 times and is guaranteed to exist. Follow-up: linear time, O(1) extra space. [3,2,3] → 3. [2,2,1,1,1,2,2] → 2.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hash counts, sort and pick the median, Excel titles, or Two Sum II', 'next' => 'hash'],
                ['label' => 'Boyer-Moore: one candidate m and a counter that cancels mismatches', 'next' => 'vote'],
            ],
        ],
        'hash' => [
            'message' => "A map is O(n) extra. Sorting is O(n log n). Excel titles and Two Sum II are other problems. Majority Element II (n/3) is a later cousin.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the first element; majority is always nums[0]', 'next' => 'wrong_first'],
                ['label' => 'If cnt is 0, set m to x. Else add 1 when x equals m, else subtract 1', 'next' => 'vote'],
            ],
        ],
        'wrong_first' => [
            'message' => "You are wrong here.\n[3,2,3] starts with 3, but [2,2,1,1,1,2,2] also happens to start with the answer — that is luck, not the algorithm.\nStep back to when you trusted index 0.",
            'outcome' => 'wrong',
            'rewind_to' => 'hash',
            'choices' => [],
        ],
        'vote' => [
            'message' => "Because a majority exists, the first pass’s candidate is enough; no confirm scan. Walk [3,2,3]: 3 sets m=3,cnt=1; 2 cancels to 0; 3 sets m=3 again.\nWhat is [2,2,1,1,1,2,2]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2 — after 1,1,1 the count hits 0, then the last 2s reclaim m', 'next' => 'ans'],
                ['label' => '1 because three 1s appear in a row, or 3 from the other sample', 'next' => 'wrong_1'],
            ],
        ],
        'wrong_1' => [
            'message' => "You are wrong. Three 1s are not more than n/2 = 3.5, so 1 is not majority. The last two 2s win.\nStep back to when you scored the second sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'vote',
            'choices' => [],
        ],
        'ans' => [
            'message' => "Time O(n), extra O(1). [3,2,3] is 3. Not a hash map, not Excel titles.\nWhat is [3,2,3]?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '3', 'next' => 'success'],
                ['label' => '2 from the other sample, or 2 because it sits in the middle', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. Two 3s beat one 2. Do not reuse 2 from the longer sample.\nStep back to when you scored [3,2,3].",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Boyer-Moore vote: reset m when cnt hits 0; majority is guaranteed so skip the verify pass. Not a hash, not sort-median, not Excel titles, not Two Sum II. [3,2,3] → 3. [2,2,1,1,1,2,2] → 2.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
