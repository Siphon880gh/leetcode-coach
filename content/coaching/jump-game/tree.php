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
            'message' => "Problem: from index 0, nums[i] is the max jump length. Return whether you can reach n-1 (boolean). [2,3,1,1,4] → true. [3,2,1,0,4] → false. n up to 1e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count minimum jumps like Jump Game II, then check that the count is finite', 'next' => 'j2'],
                ['label' => 'Greedy: mx is farthest so far; if mx < i return false; else mx = max(mx, i+nums[i])', 'next' => 'greedy'],
            ],
        ],
        'j2' => [
            'message' => "Jump Game II needs hop layers because it asks for the minimum count. Here you only need reachability.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always jump the full nums[i] from the index you stand on', 'next' => 'wrong_full'],
                ['label' => 'Track one farthest mx; you may land anywhere in (i, i+nums[i]], so update mx at every reachable i', 'next' => 'greedy'],
            ],
        ],
        'wrong_full' => [
            'message' => "You are wrong here.\nA full hop from 0 in [2,3,1,1,4] lands on index 2. You are allowed a shorter hop onto 3, which still reaches the end. Max length is a cap, not a required stride.\nStep back to when you forced a full jump.",
            'outcome' => 'wrong',
            'rewind_to' => 'j2',
            'choices' => [],
        ],
        'greedy' => [
            'message' => "When mx < i you return false. Why is that a gap you cannot close later?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Every earlier index was already scanned; none could jump to i, so later cells are also unreachable', 'next' => 'example'],
                ['label' => 'A zero anywhere means false, because a 0 cannot jump', 'next' => 'wrong_zero'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. [2,0,0] is true: index 0 jumps over both zeros. A 0 only traps you if it sits beyond every prior reach.\nStep back to when you treated every 0 as a wall.",
            'outcome' => 'wrong',
            'rewind_to' => 'greedy',
            'choices' => [],
        ],
        'example' => [
            'message' => "[3,2,1,0,4]: mx stalls at 3, then i=4 > mx → false. If the loop finishes, return true. No hop counter.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) extra', 'next' => 'success'],
                ['label' => 'O(n²) DP: from each i try every landing j ≤ i+nums[i]', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. One left-to-right max-reach pass decides reachability. Nested landings are unnecessary.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. mx = 0. For each i: if mx < i return false; mx = max(mx, i+nums[i]). Then true. Time O(n), extra O(1). Boolean reach, not Jump Game II min hops, and not “jump exactly nums[i]”.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
