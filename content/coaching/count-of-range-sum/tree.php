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
            'message' => "Problem: count contiguous ranges whose sum sits in [lower, upper]. [-2,5,-1] with [-2, 2] → 3. n up to 1e5; values ±2³¹.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nested i,j sums, or 560 exact s−k, or 303 one range query', 'next' => 'wrong_slow'],
                ['label' => '64-bit prefixes; for each x count earlier y in [x−upper, x−lower]', 'next' => 'prefix'],
            ],
        ],
        'wrong_slow' => [
            'message' => "You are wrong here.\nO(n²) dies at 1e5. 560 is an exact target, not a closed interval. 303 returns one sum, not a count of sums in a band.\nStep back to when you nested loops or reused 560/303.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'prefix' => [
            'message' => "s[0]=0, then prefix sums in 64-bit. Walk x in s: query how many inserted y sit in [x−upper, x−lower], then insert x. Query-before-insert keeps i < j. Discretize s, s−lower, s−upper into Fenwick ranks. Merge-sort across halves also works (like 493).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Insert x before querying, or add prefixes in 32-bit int', 'next' => 'wrong_order'],
                ['label' => 'O(n log n). Seed s[0]. Count, then insert', 'next' => 'cpx'],
            ],
        ],
        'wrong_order' => [
            'message' => "You are wrong. Inserting first pairs a prefix with itself (empty range). 32-bit addition overflows on ±2³¹ values.\nStep back to when you inserted first or used 32-bit sums.",
            'outcome' => 'wrong',
            'rewind_to' => 'prefix',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "The answer fits in 32-bit; the prefixes may not.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Fenwick on compressed prefixes, or merge. Not 560, not O(n²)', 'next' => 'success'],
                ['label' => 'Return the largest range sum in [lower, upper]', 'next' => 'wrong_max'],
            ],
        ],
        'wrong_max' => [
            'message' => "You are wrong. The answer is a count of ranges, not a max sum.\nStep back to when you returned a sum instead of a count.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Prefix Fenwick (or merge) on 64-bit s. For each x, count earlier y in [x−upper, x−lower], then insert. n=1e5. Not 560, not 303.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
