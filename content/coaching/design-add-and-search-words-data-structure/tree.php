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
            'message' => "Problem: WordDictionary. addWord stores lowercase words. search is true if some stored word matches; a dot matches any letter (at most two dots). After addWord(\"bad\"), \"dad\", \"mad\": search(\"pad\") false, \"bad\" true, \".ad\" true, \"b..\" true.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep a list of all words; on search, scan every string and match dots by brute force', 'next' => 'list'],
                ['label' => 'Same 26-child trie as Implement Trie; on a dot, DFS every live child; require isEnd', 'next' => 'trie'],
            ],
        ],
        'list' => [
            'message' => "10⁴ mixed calls times scanning every stored word is too slow. Word Search (79) walks a board, not a dictionary. Implement Trie has no dots — search(\"app\") after \"apple\" is still false there too, but here \".ad\" must branch.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'n > 0 and n AND (n minus 1) is 0', 'next' => 'wrong_pow'],
                ['label' => 'addWord inserts like 208; search: a letter takes that child; a dot tries every non-null child', 'next' => 'trie'],
            ],
        ],
        'wrong_pow' => [
            'message' => "You are wrong here.\nPower of Two is a bit test. This is a trie with wildcard search.\nStep back to when you reused Power of Two.",
            'outcome' => 'wrong',
            'rewind_to' => 'list',
            'choices' => [],
        ],
        'trie' => [
            'message' => "addWord: walk or create 26 slots, set isEnd. search: letter with a missing child → false. Dot: if any child plus the suffix returns true, succeed. After the last character, return that node’s isEnd — \".ad\" must be a full word.\nWhich samples?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'pad false, bad true, .ad true, b.. true after bad/dad/mad', 'next' => 'cpx'],
                ['label' => 'Treat a dot as the letter at index 26, stored as a real child named dot', 'next' => 'wrong_dot'],
            ],
        ],
        'wrong_dot' => [
            'message' => "You are wrong. A dot is a query wildcard, not a character you insert. addWord never stores dots.\nStep back to when you stored a literal dot node.",
            'outcome' => 'wrong',
            'rewind_to' => 'trie',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "addWord O(m). search O(26^d · m) with d at most 2. Space is the trie. True only on isEnd.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Trie insert; DFS on dots; isEnd at the end; not a word list, not a board, not a bit test', 'next' => 'success'],
                ['label' => 'Any path that exists is a match; isEnd is only for addWord', 'next' => 'wrong_end'],
            ],
        ],
        'wrong_end' => [
            'message' => "You are wrong. search still needs isEnd. A prefix of a longer word is not a match, same as Implement Trie.\nStep back to when you dropped isEnd.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. addWord is Implement Trie’s insert. search walks a letter or DFS-es every child on a dot, and finishes on isEnd. At most two dots keep the branch cheap. Not a scanned word list, not Word Search’s board, not Power of Two, not a stored dot node.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
