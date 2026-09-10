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
            'message' => "Problem: true iff some vertical line reflects the point set onto itself. Duplicates allowed. [[1,1],[-1,1]] → true (x = 0). [[1,1],[-1,-1]] → false (y does not match). Up to 1e4 points.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Try every pair of points as a possible axis and test the rest', 'next' => 'wrong_pairs'],
                ['label' => 'The only candidate is midway between min x and max x. Hash the points', 'next' => 'axis'],
            ],
        ],
        'wrong_pairs' => [
            'message' => "You are wrong here. Leftmost and rightmost x must map to each other, so the axis is fixed. Pairing every pair is extra work.\nStep back to when you searched over all axes.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'axis' => [
            'message' => "Let s = minX + maxX (do not divide; stay in integers). Put unique (x, y) in a set. Every original point needs (s − x, y) in that set.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A partner with the reflected x is enough, even if y is different', 'next' => 'wrong_y'],
                ['label' => 'The partner must match y as well. [[1,1],[-1,-1]] fails because y does not pair', 'next' => 'kind'],
            ],
        ],
        'wrong_y' => [
            'message' => "You are wrong. Reflection across a vertical line keeps y. Different y is a different point.\nStep back to when you ignored y.",
            'outcome' => 'wrong',
            'rewind_to' => 'axis',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Only a vertical axis is allowed. A horizontal or diagonal mirror is a different problem. Same x with two y values still needs each y’s partner on its own.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Set of points. Partner (s − x, y). Not quadratic pairing, not a non-vertical line', 'next' => 'success'],
                ['label' => 'Allow a horizontal midline if the x-check fails, or divide s by 2 and compare floats', 'next' => 'wrong_dir'],
            ],
        ],
        'wrong_dir' => [
            'message' => "You are wrong. The prompt asks for a line parallel to the y-axis. Adding min and max keeps the partner integer without a float midpoint.\nStep back to when you changed the axis direction or divided.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Axis from min x plus max x. Every (x, y) needs (s − x, y) in the set. [[1,1],[-1,1]] is true; mismatched y is false. Not every pair as an axis.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
