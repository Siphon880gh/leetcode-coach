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
            'message' => "Problem: Logs has autoincrement id from 1 and num. Return distinct nums that appear on at least three consecutive ids. Sample: ids 1-3 are all 1 → 1. Later 1s and pairs of 2s do not count.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'GROUP BY num HAVING COUNT(1) >= 3 — three rows anywhere', 'next' => 'anywhere'],
                ['label' => 'Self-join three aliases on id and id+1 with the same num', 'next' => 'join'],
            ],
        ],
        'anywhere' => [
            'message' => "Count anywhere is wrong: a 1 on ids 1, 5, and 7 is not consecutive. Largest Number ordered pieces; here consecutiveness is the id line.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'ORDER BY num and take three equal values in a row, ignoring id gaps', 'next' => 'wrong_sort'],
                ['label' => 'Require l1.id = l2.id - 1 and l2.id = l3.id - 1, and equal nums', 'next' => 'join'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here.\nSorting by num glues equal values even when their ids are not neighbors.\nStep back to when you ignored adjacent ids.",
            'outcome' => 'wrong',
            'rewind_to' => 'anywhere',
            'choices' => [],
        ],
        'join' => [
            'message' => "Project DISTINCT l2.num AS ConsecutiveNums. A run of four 1s makes overlapping triples.\nWhy DISTINCT?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Without it, a run of four would emit the same num more than once', 'next' => 'window'],
                ['label' => 'The problem wants each matching row of Logs, not unique nums', 'next' => 'wrong_distinct'],
            ],
        ],
        'wrong_distinct' => [
            'message' => "You are wrong. The result is distinct ConsecutiveNums. Overlapping windows of four 1s must collapse to one row.\nStep back to when you dropped DISTINCT.",
            'outcome' => 'wrong',
            'rewind_to' => 'join',
            'choices' => [],
        ],
        'window' => [
            'message' => "Window twin: LAG(num) and LEAD(num) OVER (ORDER BY id). Keep rows where both neighbors equal num.\nWhat if you write OVER () with no ORDER BY?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Undefined neighbor order — always ORDER BY id', 'next' => 'success'],
                ['label' => 'Fine: Logs is already stored in id order so OVER () is enough', 'next' => 'wrong_over'],
            ],
        ],
        'wrong_over' => [
            'message' => "You are wrong. Empty OVER () is not a substitute for ORDER BY id. Neighbor windows must follow the id line.\nStep back to when you omitted ORDER BY.",
            'outcome' => 'wrong',
            'rewind_to' => 'window',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Adjacent ids, same num, three wide. DISTINCT. LAG/LEAD ordered by id. Not GROUP BY count anywhere. Time O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
