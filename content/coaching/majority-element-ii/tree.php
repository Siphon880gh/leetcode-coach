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
            'message' => "Problem: every value that appears more than floor(n/3) times. Follow-up: O(n) time, O(1) extra. n up to 5 × 10⁴. [3,2,3] → [3]. [1] → [1]. [1,2] → [1,2].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Majority Element (169) one candidate with no verify, or a hash of all counts', 'next' => 'wrongish'],
                ['label' => 'Two Boyer-Moore candidates: a third distinct value decrements both, then count them in a second pass', 'next' => 'vote'],
            ],
        ],
        'wrongish' => [
            'message' => "169 guarantees more than n/2, so one winner and no check. Here the bar is n/3: at most two answers, and leftover candidates may be fake. A hash is O(n) extra, not the follow-up.\nHow do two votes work?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Match m1 or m2 and increment. Else if a count is 0, take that slot. Else decrement both. Then verify count > n/3', 'next' => 'vote'],
                ['label' => 'Return both candidates after the first sweep with no counting pass', 'next' => 'wrong_verify'],
            ],
        ],
        'wrong_verify' => [
            'message' => "You are wrong here.\nPairing can leave a leftover that never beat n/3. Count m1 and m2 in nums before emitting.\nStep back to when you skipped the second pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'wrongish',
            'choices' => [],
        ],
        'vote' => [
            'message' => "Start m2 as a sentinel different from m1 so they are not the same slot. Skip emitting a duplicate candidate. [1,2] needs both values.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[3,2,3] → [3]; [1] → [1]; [1,2] → [1,2]', 'next' => 'cpx'],
                ['label' => 'Only keep the 169-style single majority; [1,2] would return one value', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. Both 1 and 2 appear more than floor(2/3)=0 times. One candidate misses the second.\nStep back to when you used a single vote.",
            'outcome' => 'wrong',
            'rewind_to' => 'vote',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time, O(1) extra. At most two answers. Not 169-without-verify, not a full hash map.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Two votes plus a verify pass; not 169 alone, not skipping the count, not a hash of all keys', 'next' => 'success'],
                ['label' => 'Sort and scan runs; extra log n is fine for the follow-up', 'next' => 'wrong_sort'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong. The follow-up wants linear time and O(1) extra. Sorting is neither.\nStep back to when you sorted.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Two Boyer-Moore slots; a third distinct value decrements both. Second pass keeps count > n/3. O(n)/O(1). Not 169 without verify, not a hash map, not sort, not a single candidate on [1,2].\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
