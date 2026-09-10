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
            'message' => "Problem: empty m by n water. positions[k] = [r, c] turns that cell to land. After each op, how many 4-connected islands? 3 by 3, [[0,0],[0,1],[1,2],[2,1]] → [1,1,2,3]. Duplicate land leaves the count unchanged.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Re-run Number of Islands (200) flood fill after every addLand', 'next' => 'wrong_flood'],
                ['label' => 'Union-find online: new land +1, merge 4-neighbors and −1 per real union', 'next' => 'uf'],
            ],
        ],
        'wrong_flood' => [
            'message' => "You are wrong here.\n200 paints a static grid. Re-running it after every add is O(k m n) and fails the follow-up.\nStep back to when you flood-filled each op.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'uf' => [
            'message' => "Flatten (i, j) to i × n + j. Land grid plus cnt. Already land → append cnt, skip. Else mark land, cnt += 1, then for each in-bounds land neighbor: if union merged two roots, cnt -= 1. Append cnt.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '8-connect diagonals, or skip the duplicate-land short circuit', 'next' => 'wrong_diag'],
                ['label' => 'Union returns false if already the same island; do not decrement twice', 'next' => 'cpx'],
            ],
        ],
        'wrong_diag' => [
            'message' => "You are wrong. Only four directions. Adding land twice on the same cell must not bump cnt again.\nStep back to when you 8-connected or double-counted a cell.",
            'outcome' => 'wrong',
            'rewind_to' => 'uf',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Four edges are water. Path compression plus union by size. k, m, n up to 10^4 with m × n also ≤ 10^4.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Online union-find. Not 200 per op, not 8-connect, not a duplicate bump', 'next' => 'success'],
                ['label' => 'Always decrement once per land neighbor, even if they already share a root', 'next' => 'wrong_dec'],
            ],
        ],
        'wrong_dec' => [
            'message' => "You are wrong. Two neighbors of the same island must not drop cnt twice. Only a successful union decrements.\nStep back to when you subtracted on a no-op merge.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Flatten cells. New land increments cnt; each real 4-neighbor merge decrements. Duplicates keep cnt. [1,1,2,3] for the 3 by 3 sample.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
