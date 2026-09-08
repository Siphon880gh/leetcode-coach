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
            'message' => "Problem: Employee has id, name, salary, departmentId. Department has id, name. For each department, every employee who holds that department’s highest salary (ties all stay). Columns: Department, Employee, Salary. Sample: IT Jim 90k and Max 90k; Sales Henry 80k. Joe 70k and Sam 60k drop.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'ORDER BY salary DESC LIMIT 1 — one global highest row', 'next' => 'global'],
                ['label' => 'Keep rows whose (departmentId, salary) is in GROUP BY departmentId, MAX(salary)', 'next' => 'group'],
            ],
        ],
        'global' => [
            'message' => "A global LIMIT 1 keeps only one 90k and drops Sales. Customers Who Never Order was an anti-join; Rank Scores ranked one list. Here the max is per department.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Take the three highest salaries company-wide', 'next' => 'wrong_global'],
                ['label' => 'Join Employee to Department; filter with the per-department MAX subquery', 'next' => 'group'],
            ],
        ],
        'wrong_global' => [
            'message' => "You are wrong here.\nDepartment Top Three Salaries is a later problem. This query wants every department’s top salary, including ties.\nStep back to when you took a global LIMIT.",
            'outcome' => 'wrong',
            'rewind_to' => 'global',
            'choices' => [],
        ],
        'group' => [
            'message' => "Jim and Max both match IT’s 90k. Window twin: RANK() OVER (PARTITION BY departmentId ORDER BY salary DESC), keep rk = 1.\nROW_NUMBER instead of RANK?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'ROW_NUMBER would keep only one of Jim/Max', 'next' => 'part'],
                ['label' => 'ROW_NUMBER still keeps both because the salaries are equal', 'next' => 'wrong_rn'],
            ],
        ],
        'wrong_rn' => [
            'message' => "You are wrong. ROW_NUMBER assigns 1 and 2 even on a tie. RANK (and DENSE_RANK) give both Jim and Max rk = 1.\nStep back to when you used ROW_NUMBER.",
            'outcome' => 'wrong',
            'rewind_to' => 'group',
            'choices' => [],
        ],
        'part' => [
            'message' => "Partition by department id, not a name that might collide. Pandas: merge, groupby(departmentId) salary transform max, keep salary equal to that max.\nComplexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) with a hash max per department, then a pass', 'next' => 'success'],
                ['label' => 'Must sort the whole company by salary first', 'next' => 'wrong_sort'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong. A hash of MAX per departmentId, then a scan, is enough. You do not need a global sort.\nStep back to when you required a company-wide sort.",
            'outcome' => 'wrong',
            'rewind_to' => 'part',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Per-department MAX, keep every tie. RANK rk = 1 partitioned by department id. ROW_NUMBER drops a tie. Time O(n).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
