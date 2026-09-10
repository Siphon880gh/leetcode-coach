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
            'message' => "Problem: FIFO queue (push back, pop/peek front, empty) using only stack ops: push top, pop/peek top, size, empty. At most 100 calls. push 1, push 2, peek → 1, pop → 1, empty → false. Follow-up: amortized O(1).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Implement Stack using Queues (225) rotate-on-push, or pop the bottom of a deque', 'next' => 'opp'],
                ['label' => 'Two stacks: push onto in; pop/peek pour in into out only when out is empty, then use out’s top', 'next' => 'pour'],
            ],
        ],
        'opp' => [
            'message' => "225 builds LIFO (newest at a queue front). Peeking the bottom is a deque, not a stack. One stack alone pops the newest, which is not FIFO.\nHow do you reverse once?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'in receives push. If out is empty, dump in onto out. Then pop/peek out. empty is both empty', 'next' => 'pour'],
                ['label' => 'Pour in into out on every pop even when out still has values', 'next' => 'wrong_pour'],
            ],
        ],
        'wrong_pour' => [
            'message' => "You are wrong here.\nPouring onto a nonempty out puts newer values under the current front and scrambles order.\nStep back to when you poured too often.",
            'outcome' => 'wrong',
            'rewind_to' => 'opp',
            'choices' => [],
        ],
        'pour' => [
            'message' => "Each value moves in→out at most once, so n ops cost O(n) total. peek after push 1 then 2 is 1, not 2.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'push 1, push 2, peek 1, pop 1, empty false', 'next' => 'cpx'],
                ['label' => 'After push 1 then push 2, peek is 2 because stacks are LIFO', 'next' => 'wrong_lifo'],
            ],
        ],
        'wrong_lifo' => [
            'message' => "You are wrong. The pour reverses in so the oldest sits on out. peek must be 1.\nStep back to when you treated it as a stack.",
            'outcome' => 'wrong',
            'rewind_to' => 'pour',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(1) push/empty; amortized O(1) pop/peek. Not 225, not a deque bottom, not pouring onto nonempty out.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Pour in→out only when out is empty; not 225, not peek-bottom, not LIFO peek', 'next' => 'success'],
                ['label' => 'Rotate on every push so the newest is always on top (225’s idea)', 'next' => 'wrong_225'],
            ],
        ],
        'wrong_225' => [
            'message' => "You are wrong. That rotation makes a stack. This problem is a queue: oldest at the front.\nStep back to when you copied 225.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Two stacks: push onto in; pour into out only when out is empty; pop/peek out. Amortized O(1). Not 225, not a deque, not pouring onto a nonempty out, not LIFO peek.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
