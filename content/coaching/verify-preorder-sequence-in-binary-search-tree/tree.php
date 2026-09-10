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
            'message' => "Problem: unique preorder array. True iff it is preorder of some BST. [5,2,1,3,6] is true. [5,2,6,1,3] is false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort and check inorder; or rebuild the tree then Validate BST (98)', 'next' => 'sort'],
                ['label' => 'Decreasing stack of the path; last pop is a floor; reject x < last', 'next' => 'stk'],
            ],
        ],
        'sort' => [
            'message' => "Inorder of a BST is sorted, but this array is preorder. Rebuilding then validating uses extra nodes. After you leave a left subtree, nothing smaller may appear.\nWhat is last after a right turn?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'While top < x, pop into last. Then push x. last is the new lower bound', 'next' => 'stk'],
                ['label' => 'Only compare adjacent pairs; if they are decreasing then increasing, accept', 'next' => 'wrong_adj'],
            ],
        ],
        'wrong_adj' => [
            'message' => "You are wrong here.\n[5,2,6,1,3] looks locally mixed but 1 after the right of 5 is illegal. You need a running floor, not adjacent pairs.\nStep back to when you only checked neighbors.",
            'outcome' => 'wrong',
            'rewind_to' => 'sort',
            'choices' => [],
        ],
        'stk' => [
            'message' => "[5,2,6,1,3]: 6 pops 2 then 5, last becomes 5, then 1 < 5 → false. [5,2,1,3,6] never goes below last.\nWhich follow-up?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(1) extra: reuse a prefix of the input array as the stack', 'next' => 'cpx'],
                ['label' => 'H-Index II binary search on preorder as if it were sorted citations', 'next' => 'wrong_h'],
            ],
        ],
        'wrong_h' => [
            'message' => "You are wrong. H-Index II searches a sorted citations array. This is a BST preorder check.\nStep back to when you swapped problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'stk',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) time. O(n) stack, or O(1) if you overwrite a write index in the array. Not sort-as-inorder, not 98 on a rebuilt tree, not adjacent-only.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Decreasing stack; last pop is the floor; reject anything smaller after a right turn', 'next' => 'success'],
                ['label' => 'Allow x < last after popping, because right-subtree values can be anything', 'next' => 'wrong_right'],
            ],
        ],
        'wrong_right' => [
            'message' => "You are wrong. Right-subtree values must still be ≥ the ancestor you just left. That is exactly last.\nStep back to when you dropped the floor.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. last starts at −∞. For each x: if x < last, false. Pop while top < x and store those pops in last. Push x. Do not sort, rebuild-and-validate, or check only adjacent pairs.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
