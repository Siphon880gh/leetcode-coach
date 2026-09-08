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
            'message' => "Problem: drop every node whose value equals val. [1,2,6,3,4,5,6], val=6 → [1,2,3,4,5]. Empty stays empty. [7,7,7,7], val=7 → []. Up to 10⁴ nodes.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Remove only the first match, or start at head with no dummy', 'next' => 'first'],
                ['label' => 'Dummy before head; if pre.next matches, skip it and stay; else walk pre', 'next' => 'dummy'],
            ],
        ],
        'first' => [
            'message' => "Both 6s must go. A matching first node has no predecessor unless you add a dummy. Happy Number is a digit map, not a list splice.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Remove Nth from End’s gap of n, or Rectangle Area’s overlap formula', 'next' => 'wrong_other'],
                ['label' => 'dummy.next = head; while pre.next: skip on match (do not step), else pre = pre.next', 'next' => 'dummy'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nThis deletes every given val, not the nth-from-end, and not a geometry union.\nStep back to when you reused those APIs.",
            'outcome' => 'wrong',
            'rewind_to' => 'first',
            'choices' => [],
        ],
        'dummy' => [
            'message' => "After a skip, stay on pre so a run of matches all drop. Return dummy.next so a deleted original head is covered. Recursion twin: if head.val == val, return the rest.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[1,2,6,3,4,5,6] val=6 is [1,2,3,4,5]; all-7s become empty', 'next' => 'cpx'],
                ['label' => 'Keep the last 6, or return dummy itself as the new head', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Every matching node drops, including a trailing 6. The real head is dummy.next, never the dummy.\nStep back to when you scored the samples.",
            'outcome' => 'wrong',
            'rewind_to' => 'dummy',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n). Space O(1) iterative, O(n) recursive stack.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Dummy, skip-and-stay on match; not first-only, not nth-from-end', 'next' => 'success'],
                ['label' => 'After a skip, always pre = pre.next or you will infinite-loop', 'next' => 'wrong_step'],
            ],
        ],
        'wrong_step' => [
            'message' => "You are wrong. Stepping after a skip leaves the next match in place. Stay on pre until pre.next is not val.\nStep back to when you stepped after every skip.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Dummy predecessor. Skip matching next and stay. Return dummy.next. O(n) / O(1). Not first-only, not nth-from-end, not Happy Number.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
