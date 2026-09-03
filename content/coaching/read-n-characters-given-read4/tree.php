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
            'message' => "Problem: you may only call read4(buf4), which copies up to 4 file chars and returns how many. Implement read(buf, n): write up to n chars into buf, return the count written. Called once per test. file abc, n=4 → 3. abcde, n=5 → 5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Index the file string directly, Reverse Words, Upside Down tree, or Read4 II leftover across calls', 'next' => 'direct'],
                ['label' => 'Loop read4 into a 4-slot; copy into buf until i hits n or read4 returns fewer than 4', 'next' => 'chunk'],
            ],
        ],
        'direct' => [
            'message' => "You cannot touch the file except through read4. Reverse Words and Upside Down are different problems. This problem’s read is called once, so you do not keep leftover unread chars between calls (that is Read4 II).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always copy all 4 from buf4 even if n-i is 1', 'next' => 'wrong_over'],
                ['label' => 'Copy one by one from buf4 and stop as soon as i reaches n', 'next' => 'chunk'],
            ],
        ],
        'wrong_over' => [
            'message' => "You are wrong here.\nbuf is sized for n, but you must not write more than n characters. After 4+1 for n=5 you stop; for n=2 you copy only two of the first four.\nStep back to when you over-copied.",
            'outcome' => 'wrong',
            'rewind_to' => 'direct',
            'choices' => [],
        ],
        'chunk' => [
            'message' => "i = 0; buf4 of length 4. While the last read4 count v is still 4 (start v as 5 to enter): v = read4(buf4); for each of the v chars, buf[i]=buf4[j]; i += 1; if i >= n return n. After a short read, return i (EOF).\nWhy return n early?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'You already filled the request; more read4 would skip unread file bytes you do not need this call', 'next' => 'ret'],
                ['label' => 'Keep calling read4 until EOF even after i == n', 'next' => 'wrong_eof'],
            ],
        ],
        'wrong_eof' => [
            'message' => "You are wrong. Once i == n you have the answer. Extra read4 moves the file pointer for no reason and is not required.\nStep back to when you drained the file past n.",
            'outcome' => 'wrong',
            'rewind_to' => 'chunk',
            'choices' => [],
        ],
        'ret' => [
            'message' => "If the file is shorter than n, v < 4 ends the loop and you return i < n. abc with n=4 returns 3, not 4. Destination buf is large enough for n.\nWhat does abcde with n=5 return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '5 — two read4 calls, copy 4 then 1, stop at n', 'next' => 'success'],
                ['label' => '3 like abc, or 4 because read4’s block size', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. The file has five characters and n is 5, so you write all five. 3 is the other sample.\nStep back to when you mixed the samples.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. read4 into buf4; copy until n or a short read. Return n or i. Once per test — not Read4 II leftovers, not indexing the file, not Reverse Words, not Upside Down. abc n=4 → 3.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
