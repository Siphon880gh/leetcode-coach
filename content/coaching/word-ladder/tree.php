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
            'message' => "Problem: number of words in the shortest begin→end ladder (one letter per step). hit→cog with [hot,dot,dog,lot,log,cog] → 5. If cog is missing → 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Word Ladder II’s list of all shortest paths, or DFS that may wander onto a longer ladder', 'next' => 'paths'],
                ['label' => 'BFS by layers: each hop is one letter; return the step count when you first meet the end', 'next' => 'bfs'],
            ],
        ],
        'paths' => [
            'message' => "II returns the sequences. I only wants the length. Unbounded DFS can report 6 or more on the same graph.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Restore IP, Word Search on a board, or Valid Palindrome’s two pointers', 'next' => 'wrong_other'],
                ['label' => 'Set of unused words, queue from begin, ans starts at 1, bump ans each layer, return ans on hitting end', 'next' => 'bfs'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nThose problems are other graphs or strings. This is an implicit word graph and a shortest-path count.\nStep back to when you copied those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'paths',
            'choices' => [],
        ],
        'bfs' => [
            'message' => "On a layer, try 26 replacements per index. Remove a word from the set when you enqueue it so you never visit it again. Empty queue → 0.\nWhy is the sample 5, not 4?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The answer counts words, including beginWord, not the number of letter changes', 'next' => 'ret'],
                ['label' => 'Count edges only, so hit to cog is 4', 'next' => 'wrong_edges'],
            ],
        ],
        'wrong_edges' => [
            'message' => "You are wrong. The statement asks for the number of words in the sequence, so hit-hot-dot-dog-cog is 5.\nStep back to when you counted edges.",
            'outcome' => 'wrong',
            'rewind_to' => 'bfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return an integer. No ladder → 0, not []. You do not reconstruct prev pointers.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '5 or 0 — not [[hit,hot,dot,dog,cog], ...] and not a boolean', 'next' => 'success'],
                ['label' => 'The two ladders from Word Ladder II', 'next' => 'wrong_list'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong. I returns a length. The lists belong to II.\nStep back to when you returned sequences.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. BFS layers, count words (begin included). First time you dequeue-expand into endWord, return ans. Else 0. O(n·L·26). Not Word Ladder II’s paths, not DFS, not Restore IP, not Word Search, not Palindrome.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
