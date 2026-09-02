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
            'message' => "Problem: reverse nodes in k-group. [1,2,3,4,5], k = 2 → [2,1,4,3,5]. k = 3 → [3,2,1,4,5]. Leftover nodes stay in order. Do not rewrite vals.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse the whole list, then reverse leftover nodes at the front', 'next' => 'whole'],
                ['label' => 'Dummy + walk k nodes; if you run out, stop; else reverse that window and reconnect', 'next' => 'windows'],
            ],
        ],
        'whole' => [
            'message' => "A full reverse of [1,2,3,4,5] is 5-4-3-2-1, which is not either sample. You reverse disjoint windows of exactly k.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always reverse the tail even if it has fewer than k nodes', 'next' => 'wrong_tail'],
                ['label' => 'Count k from pre; if cur hits null, return dummy.next; else cut, reverse, splice, pre = old window head', 'next' => 'windows'],
            ],
        ],
        'wrong_tail' => [
            'message' => "You are wrong here.\nThe leftover suffix must keep its original order. For k = 2 the last 5 stays last, not reversed.\nStep back to when you chose what to reverse.",
            'outcome' => 'wrong',
            'rewind_to' => 'whole',
            'choices' => [],
        ],
        'windows' => [
            'message' => "After reversing a window, the old head is now the tail of that window — that is the new pre for the next group. k = 2 is Swap Nodes in Pairs.\nWhy cut cur.next before reverse?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'So reverse only walks the k-node segment, not the rest of the list', 'next' => 'example'],
                ['label' => 'You must reverse through the dummy so the next window is included this pass', 'next' => 'wrong_cut'],
            ],
        ],
        'wrong_cut' => [
            'message' => "You are wrong. If you do not isolate the window, reverse consumes the entire remainder and you lose later groups.\nStep back to when you isolated k nodes.",
            'outcome' => 'wrong',
            'rewind_to' => 'windows',
            'choices' => [],
        ],
        'example' => [
            'message' => "[1,2,3,4,5], k = 3: reverse 1-2-3 to 3-2-1, attach 4-5 unchanged. Time one pass of pointer rewires.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) extra space — follow-up is satisfied by the dummy walk', 'next' => 'success'],
                ['label' => 'O(n k) because each window reverse rescans the prefix', 'next' => 'wrong_nk'],
            ],
        ],
        'wrong_nk' => [
            'message' => "You are wrong. Each node is reversed at most once. The k-walk is still linear in n overall.\nStep back to when you scored the scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Dummy. From pre, walk k nodes; if you cannot, stop. Cut the window, reverse it, splice it back, move pre to the old head. Leftover tail stays. Time O(n), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
