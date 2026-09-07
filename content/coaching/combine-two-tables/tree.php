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
            'message' => "Problem: report firstName, lastName, city, state for every Person. If that personId has no Address row, city and state are NULL. Any order. Sample: Allen Wang → nulls; Bob Alice → New York City, New York. Address personId 3 has no Person and does not appear.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'INNER JOIN, or start from Address, or Dungeon Game DP on a grid', 'next' => 'inner'],
                ['label' => 'FROM Person LEFT JOIN Address on personId', 'next' => 'left'],
            ],
        ],
        'inner' => [
            'message' => "An inner join keeps only matching personIds, so Allen Wang disappears. Starting from Address would emit personId 3 with no name. Dungeon Game is HP DP, not SQL.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Filter WHERE city IS NOT NULL so only people with addresses remain', 'next' => 'wrong_filter'],
                ['label' => 'Left join from Person so unmatched Address columns become NULL', 'next' => 'left'],
            ],
        ],
        'wrong_filter' => [
            'message' => "You are wrong here.\nThe problem asks to keep people without addresses and show NULL city and state. Dropping those rows is an inner join in disguise.\nStep back to when you filtered out nulls.",
            'outcome' => 'wrong',
            'rewind_to' => 'inner',
            'choices' => [],
        ],
        'left' => [
            'message' => "USING (personId) or ON Person.personId = Address.personId. Pandas: left merge on personId, then the four columns.\nDoes Allen Wang appear?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Yes, with NULL city and NULL state', 'next' => 'ans'],
                ['label' => 'No, or yes with Leetcode California from personId 3', 'next' => 'wrong_allen'],
            ],
        ],
        'wrong_allen' => [
            'message' => "You are wrong. Allen is in Person with no Address match. Address personId 3 is not a Person row, so it does not show.\nStep back to when you scored Allen Wang.",
            'outcome' => 'wrong',
            'rewind_to' => 'left',
            'choices' => [],
        ],
        'ans' => [
            'message' => "Bob Alice matches addressId 1. Time O(P + A) with a hash on personId. Not Transpose File, not an inner join.\nWhat are Bob’s city and state?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'New York City, New York', 'next' => 'success'],
                ['label' => 'NULL like Allen, or Leetcode California', 'next' => 'wrong_bob'],
            ],
        ],
        'wrong_bob' => [
            'message' => "You are wrong. Bob’s personId is 2 and that Address row is New York City, New York.\nStep back to when you scored Bob.",
            'outcome' => 'wrong',
            'rewind_to' => 'ans',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. LEFT JOIN from Person on personId. Missing addresses are NULL. Inner join would drop Allen. Address-only personId 3 does not appear. Allen → nulls; Bob → New York City, New York.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
