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
            'message' => "Problem: same read4 API, but read(buf, n) may be called many times on one file. file abc, queries [1,2,1] → [1,2,0]. [4,1] → [3,0]. Reset instance state between test cases.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stateless Read4 I (discard unread of the last 4), Reverse Words, or index the file string', 'next' => 'once'],
                ['label' => 'Instance buf4 plus i and size; drain leftovers before the next read4', 'next' => 'left'],
            ],
        ],
        'once' => [
            'message' => "Read4 I is called once, so leftover in that 4-block can be ignored. Here read(1) then read(2) on abc must still see b and c. You still cannot index the file directly.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call read4 on every read() even if three chars sit unused in buf4', 'next' => 'wrong_skip'],
                ['label' => 'Keep buf4, i, size on the object; refill only when i == size', 'next' => 'left'],
            ],
        ],
        'wrong_skip' => [
            'message' => "You are wrong here.\nread4 advances the file pointer. Calling it again after you only consumed 1 of 4 drops the rest. On abc, read(1) then read(2) would miss bc.\nStep back to when you skipped leftovers.",
            'outcome' => 'wrong',
            'rewind_to' => 'once',
            'choices' => [],
        ],
        'left' => [
            'message' => "While j < n: if i == size, size = read4(buf4); i = 0; if size == 0 break (EOF). Then copy while j < n and i < size. Return j.\nWhy break when size is 0?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'EOF: further read4 stays empty; return how many you already wrote (maybe 0)', 'next' => 'ret'],
                ['label' => 'Keep looping; a later read4 might invent more characters', 'next' => 'wrong_eof'],
            ],
        ],
        'wrong_eof' => [
            'message' => "You are wrong. After EOF, read4 returns 0 forever. Spinning does not fill n.\nStep back to when you refused to stop.",
            'outcome' => 'wrong',
            'rewind_to' => 'left',
            'choices' => [],
        ],
        'ret' => [
            'message' => "abc with [1,2,1]: first call copies a and leaves bc in buf4; second drains bc; third gets size 0 and returns 0. Unlike Read4 I, leftover must survive across calls.\nWhat is [4,1] on abc?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[3,0] — first call takes the whole file; second is EOF', 'next' => 'success'],
                ['label' => '[1,2,0] or [4,0] as if the file had four letters', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. queries [4,1] yields [3,0], not the other sample and not a fake fourth character.\nStep back to when you mixed the queries.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Persist buf4, i, size. Refill only when the leftover is empty. EOF → return j. Not Read4 I, not dropping unread of a 4-block, not Reverse Words. abc [1,2,1] → [1,2,0].\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
