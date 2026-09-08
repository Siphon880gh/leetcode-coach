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
            'message' => "Problem: Employee has id, name, salary, departmentId. Department has id, name. Keep people whose salary is among the top three unique salaries of that department. Sample IT: Max 90k (1), Joe and Randy 85k (2), Will 70k (3); Janet 69k is out. Sales has only two unique salaries — both stay.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'RANK() OVER (PARTITION BY departmentId ORDER BY salary DESC), keep rk ≤ 3', 'next' => 'rank'],
                ['label' => 'DENSE_RANK() the same way, keep rk ≤ 3', 'next' => 'dense'],
            ],
        ],
        'rank' => [
            'message' => "RANK after two 85ks makes 70k into 4 and drops Will. Department Highest Salary only needed rk = 1, where RANK and DENSE_RANK agree. Here you need distinct salary ranks.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'ROW_NUMBER so each person is a unique slot in the top three rows', 'next' => 'wrong_rn'],
                ['label' => 'DENSE_RANK: same salary same rank, next distinct is plus one', 'next' => 'dense'],
            ],
        ],
        'wrong_rn' => [
            'message' => "You are wrong here.\nROW_NUMBER would split Joe and Randy and could drop Will. The problem is top three unique salaries, not three rows.\nStep back to when you used ROW_NUMBER.",
            'outcome' => 'wrong',
            'rewind_to' => 'rank',
            'choices' => [],
        ],
        'dense' => [
            'message' => "IT: 90k is 1, both 85ks are 2, 70k is 3. Join Department for the name. Correlated twin: COUNT(DISTINCT e2.salary) of strictly higher salaries in the same department; keep when that count is less than 3.\nPandas?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Three largest unique salaries per dept; keep salary at least the cutoff', 'next' => 'cpx'],
                ['label' => 'Sort the whole company and take the first three rows', 'next' => 'wrong_cut'],
            ],
        ],
        'wrong_cut' => [
            'message' => "You are wrong. The cutoff is per department, among distinct salaries, not three company-wide rows.\nStep back to when you took a global top three.",
            'outcome' => 'wrong',
            'rewind_to' => 'dense',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Time O(n log n) with a window sort per department. Space O(n).\nWhat happens to a department with only two unique salaries?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Both unique salaries stay — there is no third to fill', 'next' => 'success'],
                ['label' => 'Drop that department, or invent a dummy third salary', 'next' => 'wrong_sales'],
            ],
        ],
        'wrong_sales' => [
            'message' => "You are wrong. Sales in the sample has two unique salaries and both people stay.\nStep back to when you scored a short department.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. DENSE_RANK partitioned by departmentId, salary descending, keep rk at most 3. RANK holes after ties. ROW_NUMBER splits equals. Correlated distinct-higher count less than 3.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
