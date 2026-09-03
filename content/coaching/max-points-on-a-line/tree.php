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
            'message' => "Problem: max number of unique points on one straight line. [[1,1],[2,2],[3,3]] → 3. Second sample → 4. n ≤ 300.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Float dy/dx as the key, Sort List merge, LRU’s recency list, or tree max path sum', 'next' => 'float'],
                ['label' => 'For each origin i, hash GCD-reduced (dx, dy) of later points; max count plus 1', 'next' => 'gcd'],
            ],
        ],
        'float' => [
            'message' => "Float slopes collide or miss from rounding. Sort List, LRU, and tree path sum are different problems. Cross-product collinearity (y2-y1)*(x3-x1) == (y3-y1)*(x2-x1) also works in O(n³).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hash the raw (dx, dy) pair with no GCD; 2/4 and 1/2 are different lines', 'next' => 'wrong_raw'],
                ['label' => 'Reduce dx, dy by gcd so equivalent slopes share one key through origin i', 'next' => 'gcd'],
            ],
        ],
        'wrong_raw' => [
            'message' => "You are wrong here.\n(2,4) and (1,2) are the same slope from i. Without GCD they sit in different buckets and you undercount.\nStep back to when you skipped the reduction.",
            'outcome' => 'wrong',
            'rewind_to' => 'float',
            'choices' => [],
        ],
        'gcd' => [
            'message' => "ans starts at 1 (one point is a line). For each i, a fresh Counter. For j > i: g = gcd(dx, dy); cnt[(dx/g, dy/g)] += 1; ans = max(ans, cnt[key] + 1). Points are unique, so no duplicate-at-i loop.\nWhy plus 1?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The counter only stores other points; origin i is not in the map', 'next' => 'ret'],
                ['label' => 'Plus 1 is for a dummy sentinel, like Sort List’s dummy.next', 'next' => 'wrong_dummy'],
            ],
        ],
        'wrong_dummy' => [
            'message' => "You are wrong. There is no dummy node. +1 is point i itself. dummy.next is a list-merge idea.\nStep back to when you treated this like Sort List.",
            'outcome' => 'wrong',
            'rewind_to' => 'gcd',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Time O(n²) with the hash; the triple loop with cross products is O(n³) and also fine at n = 300. Vertical lines: dx = 0, reduced (0, ±1) after gcd.\nWhat does [[1,1],[2,2],[3,3]] return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '3 — one slope from the first point hits both others', 'next' => 'success'],
                ['label' => '2, or 4 like the second sample', 'next' => 'wrong_ans'],
            ],
        ],
        'wrong_ans' => [
            'message' => "You are wrong. Three diagonal points are one line, so 3. The second sample is 4, not this one.\nStep back to when you mixed the samples.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Per origin, GCD-reduced slope keys; max frequency plus the origin. O(n²). Not float slope, not raw (dx, dy), not Sort List, not LRU, not tree path sum. Cross-product collinearity is the O(n³) twin.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
