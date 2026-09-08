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
            'message' => "Problem: Person has id and lowercase email. Delete duplicate emails, keep the smallest id per address. Write DELETE, not SELECT. Sample: keep john id 1, drop john id 3, keep bob id 2.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'SELECT like Duplicate Emails (182), listing emails that appear more than once', 'next' => 'other'],
                ['label' => 'DELETE p2 from a self-join on email where p1.id is less than p2.id', 'next' => 'del'],
            ],
        ],
        'other' => [
            'message' => "182 only reports the repeated addresses. This problem mutates the table: extras must disappear.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep the largest id, or DELETE every john row', 'next' => 'wrong_keep'],
                ['label' => 'Keep min id; delete the rest for that email', 'next' => 'del'],
            ],
        ],
        'wrong_keep' => [
            'message' => "You are wrong here.\nThe spec is the smallest id. Dropping every john row loses the unique copy too.\nStep back to when you kept the max id.",
            'outcome' => 'wrong',
            'rewind_to' => 'other',
            'choices' => [],
        ],
        'del' => [
            'message' => "DELETE p2 FROM Person p1 JOIN Person p2 ON p1.email = p2.email WHERE p1.id < p2.id. Twin: delete ids not in MIN(id) GROUP BY email (wrap Person in a derived table on MySQL). Pandas: sort by id, drop_duplicates email keep first.\nWhat remains for john?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'id 1 only', 'next' => 'cpx'],
                ['label' => 'id 3 only, or both 1 and 3', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Same email, smaller id wins: keep 1, drop 3.\nStep back to when you scored the sample.",
            'outcome' => 'wrong',
            'rewind_to' => 'del',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "With an email index, a hash of unique emails is enough extra space for the min-id set.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'DELETE extras; keep smallest id; not a SELECT-only answer', 'next' => 'success'],
                ['label' => 'SELECT the survivors and stop; the table may still hold duplicates', 'next' => 'wrong_select'],
            ],
        ],
        'wrong_select' => [
            'message' => "You are wrong. The driver inspects Person after your script. A SELECT does not shrink the table.\nStep back to when you stopped at SELECT.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. DELETE the larger id when the email matches. Not Duplicate Emails’ SELECT, not keeping the max id. Min-id per email stays.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
