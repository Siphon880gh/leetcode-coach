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
            'message' => "Problem: LIFO stack (push, pop, top, empty) using only queue ops: enqueue back, dequeue/peek front, size, empty. At most 100 calls. push 1, push 2, top → 2, pop → 2, empty → false. Follow-up: one queue.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Implement Queue using Stacks (232), or pop/peek the back of a deque', 'next' => 'opp'],
                ['label' => 'On push, enqueue x then rotate older values behind it so the front is the stack top', 'next' => 'rot'],
            ],
        ],
        'opp' => [
            'message' => "232 is FIFO from two stacks (pour in→out). Peeking the back is a deque, not a queue. A naive enqueue leaves the oldest at the front, which is queue order, not stack.\nHow do you make newest first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Two queues: enqueue x into empty q2, dump q1 into q2, swap. Or one queue: enqueue x, rotate size−1', 'next' => 'rot'],
                ['label' => 'Use a language list as a stack and ignore the queue-ops rule', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong here.\nOnly enqueue-back and dequeue-front (plus size/empty). A raw stack list cheats.\nStep back to when you skipped the queue contract.",
            'outcome' => 'wrong',
            'rewind_to' => 'opp',
            'choices' => [],
        ],
        'rot' => [
            'message' => "After a push the front is x. pop/top take that front. empty is queue empty. push is O(n); the rest O(1).\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'push 1, push 2, top 2, pop 2, empty false', 'next' => 'cpx'],
                ['label' => 'After push 1 then push 2, top is still 1 because queues are FIFO', 'next' => 'wrong_fifo'],
            ],
        ],
        'wrong_fifo' => [
            'message' => "You are wrong. The rotate (or q2 dump) puts 2 at the front. top must be 2.\nStep back to when you left FIFO order in place.",
            'outcome' => 'wrong',
            'rewind_to' => 'rot',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) push, O(1) pop/top/empty, O(n) space. One queue is enough. Not 232, not a back-peek deque.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Newest at the front; not 232, not peek-back, not a raw stack list, not FIFO top', 'next' => 'success'],
                ['label' => 'pop should dequeue the oldest (true queue order)', 'next' => 'wrong_old'],
            ],
        ],
        'wrong_old' => [
            'message' => "You are wrong. pop removes the stack top — the newest — which you parked at the front.\nStep back to when you popped the oldest.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Rotate (or two-queue dump) so the newest sits at the front. pop/top/empty are the queue front. O(n) push. Not 232, not a deque back, not a raw list stack.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
