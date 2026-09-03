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
            'message' => "Problem: stack with push, pop, top, and getMin, each O(1). Sample: push -2, 0, -3; getMin is -3; pop; top is 0; getMin is -2. Pop/top/getMin only on nonempty.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Scan the whole stack for min, LRU’s map+DLL, RPN evaluate, or one global min that never updates on pop', 'next' => 'scan'],
                ['label' => 'Two stacks: values, and a parallel running min (seeded with +inf)', 'next' => 'twin'],
            ],
        ],
        'scan' => [
            'message' => "A scan is O(n), not O(1). LRU is a cache, RPN is postfix eval. A single stored min is stale after you pop that min.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Find Min in Rotated Array’s binary search on the stack cells', 'next' => 'wrong_bin'],
                ['label' => 'On each push, store min(val, previous running min) so pop restores the prior min', 'next' => 'twin'],
            ],
        ],
        'wrong_bin' => [
            'message' => "You are wrong here.\nThe stack is not a rotated sorted array. You need O(1) after each mutating call, not log n search.\nStep back to when you reused Find Min I/II.",
            'outcome' => 'wrong',
            'rewind_to' => 'scan',
            'choices' => [],
        ],
        'twin' => [
            'message' => "stk1 holds values. stk2 starts as [inf]. push: stk1.append(val); stk2.append(min(val, stk2[-1])). pop both. top is stk1[-1]; getMin is stk2[-1].\nWhy pop both?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Each value has a matching running-min snapshot; dropping only stk1 would desync getMin', 'next' => 'ret'],
                ['label' => 'Leave stk2; getMin can stay at the all-time min even after that value is gone', 'next' => 'wrong_leave'],
            ],
        ],
        'wrong_leave' => [
            'message' => "You are wrong. After popping -3, getMin must become -2, not stay -3. The min stack must pop in lockstep.\nStep back to when you left stk2 alone.",
            'outcome' => 'wrong',
            'rewind_to' => 'twin',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Each op O(1), extra O(n). Duplicates are fine: a second copy of the min still has its own snapshot. After the sample, top is 0 and getMin is -2.\nWhat does getMin return right after pushing -3?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '-3, then after pop it is -2', 'next' => 'success'],
                ['label' => '-2 the whole time, or 0 like top', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. With -3 on the stack, getMin is -3. After pop, top is 0 and getMin is -2.\nStep back to when you mixed top with getMin.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Twin stacks; running min on push; pop both. O(1). Not a scan, not a stale global min, not LRU, not RPN, not rotated Find Min. After -3 pops, getMin is -2.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
