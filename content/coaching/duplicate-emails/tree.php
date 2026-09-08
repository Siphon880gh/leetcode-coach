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
            'message' => "Problem: Person has id and email (lowercase, never NULL). Return emails that appear more than once. Any order. Sample: two a@b.com and one c@d.com → only a@b.com.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'WHERE COUNT(1) > 1 on the raw Person table, then SELECT email', 'next' => 'where'],
                ['label' => 'GROUP BY email, then HAVING COUNT(1) > 1', 'next' => 'group'],
            ],
        ],
        'where' => [
            'message' => "WHERE runs before grouping. COUNT(1) is not a per-row filter on the raw table. Employees vs Managers joined two roles; here you collapse rows that share an email.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Filter with WHERE email IN (SELECT email FROM Person) — that keeps every email', 'next' => 'wrong_in'],
                ['label' => 'GROUP BY email first; HAVING sees the group size', 'next' => 'group'],
            ],
        ],
        'wrong_in' => [
            'message' => "You are wrong here.\nA subquery of every email matches every row. You need groups whose size is greater than 1.\nStep back to when you filtered with WHERE COUNT.",
            'outcome' => 'wrong',
            'rewind_to' => 'where',
            'choices' => [],
        ],
        'group' => [
            'message' => "SELECT email FROM Person GROUP BY email HAVING COUNT(1) > 1. GROUP BY email reads clearer than GROUP BY 1. Unique emails drop; a@b.com stays.\nSelf-join twin?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'p1.email = p2.email AND p1.id != p2.id, then DISTINCT p1.email', 'next' => 'pandas'],
                ['label' => 'Join on id equality so each person pairs with themselves', 'next' => 'wrong_id'],
            ],
        ],
        'wrong_id' => [
            'message' => "You are wrong. Same id is the same row, not a duplicate. You need two different ids sharing an email, then DISTINCT because three copies make several pairs.\nStep back to when you joined on id.",
            'outcome' => 'wrong',
            'rewind_to' => 'group',
            'choices' => [],
        ],
        'pandas' => [
            'message' => "Pandas: person.duplicated(subset=[\"email\"]), keep the email column, then drop_duplicates so a@b.com appears once.\nComplexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) with a hash on email', 'next' => 'success'],
                ['label' => 'O(n²) compare every pair of rows in nested loops', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. Grouping or a hash on email is linear in the number of rows, not every pair.\nStep back to when you scored the complexity.",
            'outcome' => 'wrong',
            'rewind_to' => 'pandas',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. GROUP BY email HAVING COUNT(1) > 1. Self-join on email with different ids plus DISTINCT. Time O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
