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
            'message' => "Problem: Employee has id, name, salary, managerId. Names of workers whose salary is strictly greater than their manager’s. Sample: Joe 70k under Sam 60k → Joe. Henry 80k under Max 90k → out. Sam and Max have NULL managerId → out.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'LEFT JOIN so CEOs stay, then compare salary to a NULL manager', 'next' => 'left'],
                ['label' => 'INNER JOIN Employee to itself: worker.managerId = boss.id, then worker.salary > boss.salary', 'next' => 'inner'],
            ],
        ],
        'left' => [
            'message' => "A LEFT JOIN keeps CEOs. Their manager salary is NULL, and a comparison to NULL is unknown — not “greater.” Consecutive Numbers joined adjacent ids; here the key is a foreign key.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'COALESCE the manager salary to 0 so CEOs always win', 'next' => 'wrong_zero'],
                ['label' => 'INNER JOIN drops unmatched managerId; only workers with a boss remain', 'next' => 'inner'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong here.\nCEOs have no manager to beat. Combine Two Tables used a left join to keep unmatched people; this query should drop them.\nStep back to when you kept CEOs.",
            'outcome' => 'wrong',
            'rewind_to' => 'left',
            'choices' => [],
        ],
        'inner' => [
            'message' => "Alias e1 as worker, e2 as boss. WHERE e1.salary > e2.salary. Project e1.name AS Employee. Sample: Joe stays; Henry does not.\nWhat about Sam and Max?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'NULL managerId matches no id, so they disappear', 'next' => 'pandas'],
                ['label' => 'They appear with a blank Employee name', 'next' => 'wrong_sam'],
            ],
        ],
        'wrong_sam' => [
            'message' => "You are wrong. An inner join needs a matching boss row. NULL managerId never matches an id.\nStep back to when you scored Sam and Max.",
            'outcome' => 'wrong',
            'rewind_to' => 'inner',
            'choices' => [],
        ],
        'pandas' => [
            'message' => "Pandas: merge on left_on=managerId, right_on=id, keep salary > salary_manager.\nComplexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) with a hash on id', 'next' => 'success'],
                ['label' => 'O(n²) nested loops over every pair of employees', 'next' => 'wrong_n2'],
            ],
        ],
        'wrong_n2' => [
            'message' => "You are wrong. Join on managerId = id is a keyed lookup, not every pair.\nStep back to when you scored the complexity.",
            'outcome' => 'wrong',
            'rewind_to' => 'pandas',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Self-join worker to boss on managerId. INNER JOIN. Strictly greater salary. CEOs drop. Time O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
