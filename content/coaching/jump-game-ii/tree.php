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
            'message' => "Problem: from index 0, nums[i] is the farthest you may jump forward. Return the minimum number of jumps to n-1. You can always reach. [2,3,1,1,4] → 2. n up to 1e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Answer 1 if the last index is reachable, else 0 — that is Jump Game I', 'next' => 'can'],
                ['label' => 'Greedy BFS: track farthest mx in the current jump; when i hits last, ans++ and last = mx', 'next' => 'greedy'],
            ],
        ],
        'can' => [
            'message' => "Jump Game I only asks whether you can arrive. Here you must count jumps. Reachability is given.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'If reachable, the min jump count is always 1 (leap from 0 to n-1)', 'next' => 'wrong_one'],
                ['label' => 'Each jump covers a window; end the window at last, then start a new jump out to the max reach seen', 'next' => 'greedy'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong here.\nFrom index 0 you may not be able to land on n-1 in one hop. [2,3,1,1,4] needs two jumps (0→1→4), not one.\nStep back to when you counted hops.",
            'outcome' => 'wrong',
            'rewind_to' => 'can',
            'choices' => [],
        ],
        'greedy' => [
            'message' => "From i you may land anywhere in (i, i+nums[i]]. Why not always take the full nums[i] from the current index?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A shorter hop can land on a larger nums[j] that reaches farther next; scan the whole window for mx', 'next' => 'example'],
                ['label' => 'Greedy means always jump nums[i] from the index you stand on', 'next' => 'wrong_full'],
            ],
        ],
        'wrong_full' => [
            'message' => "You are wrong. Full jump from 0 in [2,3,1,1,4] lands on index 2 (value 1), which is worse than stepping to index 1 (value 3).\nStep back to when you chose how far to jump.",
            'outcome' => 'wrong',
            'rewind_to' => 'greedy',
            'choices' => [],
        ],
        'example' => [
            'message' => "Loop i from 0 to n-2 (do not jump from the last index). mx = max(mx, i+nums[i]). If i == last: ans += 1; last = mx. [2,3,1,1,4] → 2.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) extra', 'next' => 'success'],
                ['label' => 'O(n²) DP over every landing is required for the true minimum', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. One left-to-right pass records the farthest the current jump can reach. The layer ends at last; that is enough for the minimum.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. For i in [0, n-2]: mx = max(mx, i+nums[i]); when i == last, increment ans and set last = mx. Time O(n), extra O(1). Min jumps, not a boolean reach.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
