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
            'message' => "Problem: n people, at most one celebrity (known by everyone, knows nobody). Only knows(a, b). Return the label or −1. Sample: person 1 is the sink → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call knows on every pair (n² queries)', 'next' => 'all'],
                ['label' => 'Each knows() kills one person; keep one candidate, then verify', 'next' => 'elim'],
            ],
        ],
        'all' => [
            'message' => "n² is correct but the follow-up is about 3n calls. If knows(a, b) is true, a is not a celebrity; if false, b is not.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Return the first-pass candidate with no second loop', 'next' => 'wrong_skip'],
                ['label' => 'Start ans = 0; if knows(ans, i) then ans = i. Then verify everyone vs ans', 'next' => 'elim'],
            ],
        ],
        'wrong_skip' => [
            'message' => "You are wrong here.\nThe elimination pass only proves at most one candidate. That person may still know someone, or someone may not know them.\nStep back to when you skipped verification.",
            'outcome' => 'wrong',
            'rewind_to' => 'all',
            'choices' => [],
        ],
        'elim' => [
            'message' => "Second loop: for every i ≠ ans, if knows(ans, i) or not knows(i, ans), return −1. Else return ans.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Person 1 known by 0 and 2, knows nobody → 1. A cycle with no sink → −1', 'next' => 'cpx'],
                ['label' => 'Treat knows(ans, ans) as a fail because the diagonal is 1', 'next' => 'wrong_self'],
            ],
        ],
        'wrong_self' => [
            'message' => "You are wrong. Skip i == ans in the check. Self-knows is not part of the celebrity definition.\nStep back to when you queried the diagonal.",
            'outcome' => 'wrong',
            'rewind_to' => 'elim',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n) knows calls (about 3n), O(1) extra.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Eliminate to one candidate, then verify both directions. Not every pair, not skip verify', 'next' => 'success'],
                ['label' => 'Celebrity must know exactly one person (themselves)', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. A celebrity knows nobody else. Do not require a self-knows edge.\nStep back to when you required a self loop.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. If the candidate knows i, switch to i. Then verify: the survivor knows nobody and everyone knows them. Else −1. Not n² pairs, not a skip of the check.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
