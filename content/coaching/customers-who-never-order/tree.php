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
            'message' => "Problem: Customers has id, name. Orders has id, customerId. Names of customers with no order row. Any order. Sample: Joe and Sam ordered; Henry and Max did not.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'INNER JOIN Customers to Orders on id = customerId, then SELECT name', 'next' => 'inner'],
                ['label' => 'LEFT JOIN Orders, then WHERE o.id IS NULL', 'next' => 'left'],
            ],
        ],
        'inner' => [
            'message' => "An inner join keeps only people who ordered — Joe and Sam. Combine Two Tables used a left join to keep unmatched people; Duplicate Emails grouped one table. Here the unmatched customers are the answer.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'WHERE o.customerId IS NOT NULL after the inner join', 'next' => 'wrong_inner'],
                ['label' => 'Start from Customers LEFT JOIN Orders ON c.id = o.customerId', 'next' => 'left'],
            ],
        ],
        'wrong_inner' => [
            'message' => "You are wrong here.\nAn inner join already dropped Henry and Max. Filtering matched rows cannot bring them back.\nStep back to when you inner-joined.",
            'outcome' => 'wrong',
            'rewind_to' => 'inner',
            'choices' => [],
        ],
        'left' => [
            'message' => "Unmatched customers have NULL on the order side. Filter WHERE o.id IS NULL. Project name AS Customers.\nNOT IN twin?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'id NOT IN (SELECT customerId FROM Orders) — same set if customerId is never NULL', 'next' => 'pandas'],
                ['label' => 'NOT IN is always safe even when the subquery can contain NULL', 'next' => 'wrong_notin'],
            ],
        ],
        'wrong_notin' => [
            'message' => "You are wrong. A NULL inside a NOT IN list makes the predicate unknown for every row. Prefer NOT EXISTS if the subquery can contain NULL.\nStep back to when you treated NOT IN as always safe.",
            'outcome' => 'wrong',
            'rewind_to' => 'left',
            'choices' => [],
        ],
        'pandas' => [
            'message' => "Pandas: customers whose id is not in orders[\"customerId\"]. Complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(C + O) with a hash of order customer ids', 'next' => 'success'],
                ['label' => 'O(C × O) nested loops with no hash', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. Hash the order customer ids, then scan Customers. That is linear in both tables, not every pair.\nStep back to when you scored the complexity.",
            'outcome' => 'wrong',
            'rewind_to' => 'pandas',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. LEFT JOIN then WHERE o.id IS NULL. NOT IN when customerId is never NULL. Inner join would keep only people who ordered. Time O(C + O).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
