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
            'message' => "Problem: all root-to-leaf paths as strings, any order. A leaf has no children. [1,2,3,null,5] → [\"1->2->5\",\"1->3\"]. [1] → [\"1\"].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Path Sum II: keep paths whose sum hits a target; or dump inorder values', 'next' => 'sum'],
                ['label' => 'DFS shared buffer: push str(val); at a leaf join with -> ; else recurse; then pop', 'next' => 'dfs'],
            ],
        ],
        'sum' => [
            'message' => "113 filters by sum. Inorder is left-root-right, not root-to-leaf strings. Here every chain counts, formatted with arrows.\nWhen do you record?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only when both children are null. A lone root is a leaf, so ["1"] with no arrows', 'next' => 'dfs'],
                ['label' => 'Emit a string at every node, including internal ones', 'next' => 'wrong_internal'],
            ],
        ],
        'wrong_internal' => [
            'message' => "You are wrong here.\nInternal prefixes like \"1->2\" are not answers unless that node is a leaf.\nStep back to when you recorded at every node.",
            'outcome' => 'wrong',
            'rewind_to' => 'sum',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Join with \"->\", not commas. Copy the joined string; the buffer will change. Then pop so the right sibling does not keep the left child’s value.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2,3,null,5] → 1->2->5 and 1->3', 'next' => 'cpx'],
                ['label' => 'Skip the pop so the buffer stays as a growing log of the whole walk', 'next' => 'wrong_pop'],
            ],
        ],
        'wrong_pop' => [
            'message' => "You are wrong. Without pop, left values leak into the right path (\"1->2->5->3\").\nStep back to when you skipped the pop.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n²) time if each join copies a path of length O(n). O(n) space. Not Path Sum II, not inorder, not Find the Celebrity.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Push, join only at a leaf, recurse, pop', 'next' => 'success'],
                ['label' => 'Find the Celebrity: knows() on tree edges', 'next' => 'wrong_celeb'],
            ],
        ],
        'wrong_celeb' => [
            'message' => "You are wrong. Celebrity is an API graph. This is root-to-leaf strings on a binary tree.\nStep back to when you swapped problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Shared buffer t. Push the value. If both children are null, append \"->\".join(t). Else dfs left and right. Always pop. Do not record at internal nodes, skip the pop, or filter by path sum.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
