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
            'message' => "Problem: Weather has unique id, unique recordDate, temperature. Return ids hotter than yesterday. Any order. Sample 10, 25, 20, 30 on consecutive January dates → ids 2 and 4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Join on w1.id = w2.id + 1, or compare each row to the global min temperature', 'next' => 'other'],
                ['label' => 'Self-join: DATEDIFF(w1.recordDate, w2.recordDate) = 1 and w1.temperature > w2.temperature', 'next' => 'join'],
            ],
        ],
        'other' => [
            'message' => "Ids need not be consecutive. Yesterday is a calendar day, not “previous id.” Global min is not yesterday.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'A two-day gap still counts as yesterday', 'next' => 'wrong_gap'],
                ['label' => 'Join on date plus one, then a strict temperature increase', 'next' => 'join'],
            ],
        ],
        'wrong_gap' => [
            'message' => "You are wrong here.\nA skipped date is not yesterday. DATEDIFF must be 1.\nStep back to when you treated a gap as yesterday.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'join' => [
            'message' => "Select w1.id. SUBDATE(w1.recordDate, 1) = w2.recordDate is the same join. Pandas: sort by date, keep temperature.diff() > 0 and date.diff() exactly 1 day.\nWhich sample ids?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2 and 4', 'next' => 'cpx'],
                ['label' => '2, 3, and 4 (keep 20 because it follows 25) or only 4', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. 20 is cooler than 25, so id 3 is out. 25 after 10 and 30 after 20 stay.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'join',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Hash the date or join: O(n) time, O(n) extra.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Yesterday by date, strictly warmer; equal temps drop', 'next' => 'success'],
                ['label' => 'Keep equal temperatures as “not cooler”', 'next' => 'wrong_eq'],
            ],
        ],
        'wrong_eq' => [
            'message' => "You are wrong. The problem is strictly higher than yesterday, not greater-or-equal.\nStep back to when you kept ties.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Self-join on date plus one and a warmer temperature. Not id minus 1, not a date gap, not equal temps. O(n) / O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
