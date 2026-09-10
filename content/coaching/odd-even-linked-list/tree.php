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
            'message' => "Problem: group odd-index nodes, then even-index nodes. First node is odd (1-based). Order inside each group stays. [1,2,3,4,5] → [1,3,5,2,4]. O(n) time, O(1) extra.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Partition by node.val % 2 (like 86), or copy into an array', 'next' => 'wrong_val'],
                ['label' => 'Odd tail, even tail, save even head; weave, then join', 'next' => 'weave'],
            ],
        ],
        'wrong_val' => [
            'message' => "You are wrong here.\nThe split is index, not value. [2,1,3,…] starts with even values on odd indices. An array rebuild is extra O(n) space.\nStep back to when you partitioned by value or allocated a list copy.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'weave' => [
            'message' => "a = head (odd tail), b = c = head.next (even tail and even head). While b and b.next: a.next = b.next; a = a.next; b.next = a.next; b = b.next. Then a.next = c. Return head. Empty list: return None.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Drop c before the join, or move head to the even chain', 'next' => 'wrong_c'],
                ['label' => 'O(1) extra. Head stays the odd head', 'next' => 'cpx'],
            ],
        ],
        'wrong_c' => [
            'message' => "You are wrong. c is the even-chain start; without it the join is lost. The odd head is still the original head.\nStep back to when you lost the even head or returned the even list first.",
            'outcome' => 'wrong',
            'rewind_to' => 'weave',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "One or two nodes: the loop never runs (or b is null); still a.next = c.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Index groups, two tails plus even head. Not 86, not O(n) extra', 'next' => 'success'],
                ['label' => 'Sort the whole list so odd values come first', 'next' => 'wrong_sort'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong. Relative order inside each index group must stay, and the split is not by value.\nStep back to when you sorted by value.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Odd indices, then even. Weave two tails; join with the saved even head. O(1) extra. Not Partition List.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
