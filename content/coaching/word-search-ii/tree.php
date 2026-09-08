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
            'message' => "Problem: m by n board, unique words (up to 30k, length ≤ 10). Return every word that appears as a 4-neighbor path with no cell reused in that word. Sample board with oath/pea/eat/rain → [\"eat\",\"oath\"]. 2 by 2 abcd vs abcb → [].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Word Search I for each word: from every cell, DFS that one string', 'next' => 'loop'],
                ['label' => 'Insert all words into a trie; DFS the board along trie children; emit a word once', 'next' => 'trie'],
            ],
        ],
        'loop' => [
            'message' => "30k words times 12 by 12 starts times 4^10 times out. Design Add and Search Words stores a dictionary with dots, but it is not a board. Implement Queue using Stacks pours two stacks — unrelated.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'push onto in; pour into out only when out is empty', 'next' => 'wrong_q'],
                ['label' => 'One trie of all words. From each cell, walk children, mark #, restore; on ref ≥ 0 append and clear ref', 'next' => 'trie'],
            ],
        ],
        'wrong_q' => [
            'message' => "You are wrong here.\nTwo stacks build a queue. This is a board plus a prefix tree.\nStep back to when you reused queue-using-stacks.",
            'outcome' => 'wrong',
            'rewind_to' => 'loop',
            'choices' => [],
        ],
        'trie' => [
            'message' => "dfs(node, i, j): no child for this letter → return. Step. If ref ≥ 0, append words[ref], set ref = −1. Write #, recurse 4-neighbors that are not #, restore. Shared prefixes share one walk. Diagonals are illegal. abcb reuses b and must fail.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'oath/pea/eat/rain → eat and oath; abcb on 2 by 2 → empty', 'next' => 'cpx'],
                ['label' => 'Allow diagonals; skip the # mark so a cell can be used twice in one word', 'next' => 'wrong_reuse'],
            ],
        ],
        'wrong_reuse' => [
            'message' => "You are wrong. Adjacent means up/down/left/right. The same cell may not be reused in one word — that is why abcb is empty.\nStep back to when you allowed reuse or diagonals.",
            'outcome' => 'wrong',
            'rewind_to' => 'trie',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(m n 4^L) with L ≤ 10, plus building the trie. Space is the trie plus O(L) recursion. Emit each word at most once.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Trie on the board, mark/restore, clear ref after emit; not Word Search I in a loop, not a queue', 'next' => 'success'],
                ['label' => 'Leave ref set so every path that finishes the same word appends it again', 'next' => 'wrong_dup'],
            ],
        ],
        'wrong_dup' => [
            'message' => "You are wrong. Clear the index after the first emit so a later path does not duplicate the word.\nStep back to when you kept ref.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. One trie of all words. DFS the board along children, mark #, restore. Append on ref ≥ 0 then clear it. 4-neighbors, no reuse. Not Word Search I per word, not a queue adapter, not diagonals, not duplicate emits.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
