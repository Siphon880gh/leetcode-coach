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
            'message' => "Problem: return every shortest begin→end ladder (one letter per step, words from the list). hit→cog with [hot,dot,dog,lot,log,cog] → two paths of length 5. If cog is missing → [].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Word Ladder I’s integer length, or DFS/backtracking alone without a shortest-layer BFS', 'next' => 'len'],
                ['label' => 'BFS by layers, record every predecessor at the first distance you meet a word, then DFS the DAG', 'next' => 'bfs'],
            ],
        ],
        'len' => [
            'message' => "Word Ladder I returns 5 (or 0). Here the judge wants the actual sequences. Plain DFS can find longer hit-hot-dot-lot-log-cog paths.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Restore IP’s dotted segments, Word Search’s board DFS, or Valid Palindrome’s two pointers', 'next' => 'wrong_other'],
                ['label' => 'If end not in the set, return []. BFS until the end’s layer; prev[word] holds parents; DFS from the end', 'next' => 'bfs'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nRestore IP and Word Search are different graphs. Palindrome is two pointers. This is an implicit word graph plus reconstruction.\nStep back to when you copied those problems.",
            'outcome' => 'wrong',
            'rewind_to' => 'len',
            'choices' => [],
        ],
        'bfs' => [
            'message' => "On each layer, generate 26 letter swaps. If you already queued t at this same step, still add the extra parent. Stop expanding after the layer that hits endWord.\nWhy DFS from the end, not from the start?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'prev points backward; walk to beginWord, reverse the path, pop on the way back', 'next' => 'ret'],
                ['label' => 'Keep BFS after finding cog so every longer ladder is included too', 'next' => 'wrong_long'],
            ],
        ],
        'wrong_long' => [
            'message' => "You are wrong. Only shortest sequences. Once a layer contains the end, later layers are longer and must be skipped.\nStep back to when you kept searching past the first hit.",
            'outcome' => 'wrong',
            'rewind_to' => 'bfs',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return a list of word lists, or []. beginWord does not have to sit in wordList.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The two ladders [[hit,hot,dot,dog,cog],[hit,hot,lot,log,cog]], or [] — not the integer 5', 'next' => 'success'],
                ['label' => 'Only one ladder, or the length 5 like Word Ladder I', 'next' => 'wrong_one'],
            ],
        ],
        'wrong_one' => [
            'message' => "You are wrong. All shortest ladders are required. A single path or a length is Word Ladder I’s API.\nStep back to when you returned one path or a count.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. BFS shortest layers + predecessor sets + DFS reverse. Missing end → []. Not Word Ladder I’s length, not unbounded DFS, not Restore IP, not Word Search, not Valid Palindrome.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
