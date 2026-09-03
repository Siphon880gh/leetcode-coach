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
            'message' => "Problem: how many structurally unique BSTs with values 1..n? n = 3 → 5. n = 1 → 1. n ≤ 19.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Build every tree like Unique BST II, then len(); or Unique Paths on a grid', 'next' => 'build'],
                ['label' => 'DP: f[0]=1; f[i] = sum over j of f[j]*f[i-j-1] (Catalan)', 'next' => 'dp'],
            ],
        ],
        'build' => [
            'message' => "Unique BST II already enumerates shapes; here n goes to 19, so you want the count, not the forests. Unique Paths is an m×n grid, not Catalan.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Climbing Stairs: f[i]=f[i-1]+f[i-2] with no product of left and right sizes', 'next' => 'wrong_fib'],
                ['label' => 'Pick root size: left has j nodes, right has i-j-1; multiply those two counts', 'next' => 'dp'],
            ],
        ],
        'wrong_fib' => [
            'message' => "You are wrong here.\nClimbing Stairs is Fibonacci. BST counts multiply independent left and right forests.\nStep back to when you used a two-term sum.",
            'outcome' => 'wrong',
            'rewind_to' => 'build',
            'choices' => [],
        ],
        'dp' => [
            'message' => "f[0] = 1 (one empty tree). Nested loops: for i in 1..n, for j in 0..i-1, f[i] += f[j]*f[i-j-1]. Time O(n²).\nWhy multiply, not add, the two sides?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Every left shape pairs with every right shape — a cartesian product of counts', 'next' => 'ret'],
                ['label' => 'Add f[j]+f[i-j-1] like Unique Paths adding above and left', 'next' => 'wrong_add'],
            ],
        ],
        'wrong_add' => [
            'message' => "You are wrong. Unique Paths adds two incoming routes into one cell. Here a left forest and a right forest combine independently, so you multiply.\nStep back to when you added.",
            'outcome' => 'wrong',
            'rewind_to' => 'dp',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return f[n], an integer. Not a list of roots.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The Catalan count G(n)', 'next' => 'success'],
                ['label' => 'The five example trees as nested lists, like Unique BST II', 'next' => 'wrong_trees'],
            ],
        ],
        'wrong_trees' => [
            'message' => "You are wrong. Unique BST II returns trees. This signature returns how many.\nStep back to when you returned the forests.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. f[0]=1. f[i] = Σ f[j]*f[i-j-1]. Return f[n]. O(n²). Catalan count — not Unique BST II’s trees, not Unique Paths, not Climbing Stairs.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
