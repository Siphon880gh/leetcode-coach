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
            'message' => "Problem: inorder iterator on a BST. next() and hasNext(). Constructor sits before the smallest, so the first next is the min. Tree [7, 3, 15, null, null, 9, 20]: next is 3, then 7, hasNext true, then 9, 15, 20. Follow-up: average O(1) per call, extra O(h).\nWhat do you store?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Flatten the whole inorder list in the constructor, or walk BFS levels', 'next' => 'flat'],
                ['label' => 'A stack of the left spine; hasNext is whether the stack is nonempty', 'next' => 'stack'],
            ],
        ],
        'flat' => [
            'message' => "Dumping every value up front is extra O(n), not O(h). BFS is level order, not inorder. Inorder traversal of a binary tree is the same order, but here you must pause between calls.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Recurse the whole tree on every next', 'next' => 'wrong_all'],
                ['label' => 'Push left children in the constructor; after a pop, push that node’s right then its left chain', 'next' => 'stack'],
            ],
        ],
        'wrong_all' => [
            'message' => "You are wrong here.\nRestarting a full DFS on every next repeats work and still needs a cursor. The stack already is the paused walk.\nStep back to when you restarted the whole tree.",
            'outcome' => 'wrong',
            'rewind_to' => 'flat',
            'choices' => [],
        ],
        'stack' => [
            'message' => "Constructor pushes 7 then 3. First next pops 3. Second next pops 7, then pushes 15 then 9.\nWhat is the third next?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '9 — the stack top after pushing 15’s left spine', 'next' => 'ans'],
                ['label' => '15, or 20, skipping 9', 'next' => 'wrong_nine'],
            ],
        ],
        'wrong_nine' => [
            'message' => "You are wrong. After popping 7 you push 15 then walk left onto 9, so 9 is next, not 15.\nStep back to when you scored the third next.",
            'outcome' => 'wrong',
            'rewind_to' => 'stack',
            'choices' => [],
        ],
        'ans' => [
            'message' => "Each node is pushed and popped once, so next is amortized O(1). Stack height is O(h). hasNext is stack nonempty. Not Factorial Trailing Zeroes, not a full inorder array.\nWhat is the first next on the sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '3 — the leftmost, the min', 'next' => 'success'],
                ['label' => '7 because it is the root', 'next' => 'wrong_root'],
            ],
        ],
        'wrong_root' => [
            'message' => "You are wrong. The pointer starts before the smallest. First next is 3, not the root.\nStep back to when you scored the first next.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Left-spine stack; pop; then right’s left spine. Average O(1) next, extra O(h). Sample: 3, 7, 9, 15, 20. Not a flattened O(n) list, not BFS.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
