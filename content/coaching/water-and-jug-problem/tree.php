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
            'message' => "Problem: jugs of x and y liters, infinite tap. Fill, empty, or pour until full/empty. True if some reachable state has target liters in one jug or in both combined. 3, 5, 4 → true. 2, 6, 5 → false. 1, 2, 3 → true. Capacities and target up to 1000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always fill the larger jug once and hope the remainder is target', 'next' => 'wrong_greedy'],
                ['label' => 'Bézout: reachable totals are multiples of gcd(x, y), at most x+y. Target 0 is true', 'next' => 'gcd'],
            ],
        ],
        'wrong_greedy' => [
            'message' => "You are wrong here. 3 and 5 measure 4 only after a sequence of pours, not one fill of 5.\nStep back to when you used a single greedy fill.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'gcd' => [
            'message' => "Every pour changes amounts by ±x or ±y, so every reachable total is a multiple of gcd(x, y). You cannot hold more than x+y. So target 0 → true; target > x+y → false; else true iff target mod gcd is 0. 2 and 6 only make even totals, so 5 is impossible.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Require target in one jug only, so 1, 2, 3 is false because neither jug holds 3', 'next' => 'wrong_one'],
                ['label' => 'Success if i, j, or i+j equals target. Combined total is allowed (example 3)', 'next' => 'kind'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. Filling both 1 and 2 gives 3 in total, and the problem counts that.\nStep back to when you forbade the combined total.",
            'outcome' => 'wrong',
            'rewind_to' => 'gcd',
            'choices' => [],
        ],
        'kind' => [
            'message' => "DFS/BFS on state (i, j) with a seen set is the same search: fill, empty, pour. O(x+y) states. Use gcd when you only need yes/no.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'gcd test, or DFS on (i, j). Not greedy fill. Combined total counts', 'next' => 'success'],
                ['label' => 'Model every milliliter as its own graph node, ignoring the two jug amounts', 'next' => 'wrong_ml'],
            ],
        ],
        'wrong_ml' => [
            'message' => "You are wrong. The state is just how full each jug is. Extra milliliter nodes do not add operations you can actually perform.\nStep back to when you exploded the graph past (i, j).",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Target 0 or a multiple of gcd(x, y) not above x+y. 3, 5, 4 → true. 2, 6, 5 → false. 1, 2, 3 → true. DFS on (i, j) matches. Not a greedy fill.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
