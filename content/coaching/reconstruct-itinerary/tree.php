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
            'message' => "Problem: tickets [from, to]. Use every ticket exactly once, start at JFK. If several trips exist, return the lex-smallest airport list. [[MUC,LHR],[JFK,MUC],[SFO,SJC],[LHR,SFO]] → [JFK,MUC,LHR,SFO,SJC].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Shortest path, or visit each airport once (Hamiltonian)', 'next' => 'wrong_path'],
                ['label' => 'Directed Eulerian path from JFK: Hierholzer, then reverse', 'next' => 'euler'],
            ],
        ],
        'wrong_path' => [
            'message' => "You are wrong here. Airports can repeat; tickets are the edges you must exhaust. Shortest path ignores unused flights. Hamiltonian visits vertices, not every ticket.\nStep back to when you modeled cities instead of tickets.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'euler' => [
            'message' => "Multigraph: duplicate tickets are extra edges. From airport f, while unused outs remain, pop one destination and recurse; when stuck, append f. Reverse that list. Sort tickets reverse so a pop yields the smallest unused to first.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always board the lex-smallest unused flight immediately (greedy can dead-end)', 'next' => 'wrong_greedy'],
                ['label' => 'Post-order append, then reverse; lex via reverse-sorted pops', 'next' => 'cpx'],
            ],
        ],
        'wrong_greedy' => [
            'message' => "You are wrong. Always taking the smallest unused destination can enter a dead end that is not the last unused edge. Hierholzer postpones that edge to the end of the itinerary.\nStep back to when you committed greedy next-city.",
            'outcome' => 'wrong',
            'rewind_to' => 'euler',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(m log m) to sort edges. The problem guarantees at least one valid trip.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hierholzer from JFK, reverse the post-order. Not shortest path', 'next' => 'success'],
                ['label' => 'Return any Eulerian path and skip lex order', 'next' => 'wrong_lex'],
            ],
        ],
        'wrong_lex' => [
            'message' => "You are wrong. Among valid trips the judge wants the lex-smallest airport sequence, not an arbitrary Eulerian path.\nStep back to when you ignored lexical order.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Hierholzer from JFK: reverse-sorted pops, append after children, reverse. Not greedy next-city, not shortest path.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
