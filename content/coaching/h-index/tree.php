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
            'message' => "Problem: largest h such that at least h papers have at least h citations. [3,0,6,1,5] → 3. [1,3,1] → 1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Average the citations, or require exactly h cites per paper', 'next' => 'avg'],
                ['label' => 'Sort descending; first h with citations[h − 1] ≥ h', 'next' => 'sort'],
            ],
        ],
        'avg' => [
            'message' => "Average is not the definition. Exactly h cites would reject a paper with more than h. The bar is at least h papers at least h cites.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Binary search the unsorted array like H-Index II (275)', 'next' => 'wrong_bs'],
                ['label' => 'Sort descending, or count into buckets of size n + 1', 'next' => 'sort'],
            ],
        ],
        'wrong_bs' => [
            'message' => "You are wrong here.\n275 assumes the array is already non-decreasing. This array is unsorted, so binary search is invalid unless you sort first.\nStep back to when you binary-searched the raw list.",
            'outcome' => 'wrong',
            'rewind_to' => 'avg',
            'choices' => [],
        ],
        'sort' => [
            'message' => "After reverse sort, try h from n down. citations[h − 1] ≥ h means the h-th most-cited paper still meets the bar. Counting: cnt[min(cites, n)], add from n down until s ≥ h.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '[3,0,6,1,5] sorted 6,5,3,1,0 → h = 3. [1,3,1] → 1', 'next' => 'cpx'],
                ['label' => 'Return n whenever any paper has n cites', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. One highly cited paper does not give h = n unless every paper meets the bar. [6] is h = 1, not a free n.\nStep back to when you equated max cite with n.",
            'outcome' => 'wrong',
            'rewind_to' => 'sort',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(n log n) sort, or O(n) counting with O(n) buckets. h cannot exceed n, so clamp cites at n.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Descending sort or count-down. At least h, not exactly h. Not 275 on an unsorted list', 'next' => 'success'],
                ['label' => 'h can be larger than n if some cites exceed n', 'next' => 'wrong_cap'],
            ],
        ],
        'wrong_cap' => [
            'message' => "You are wrong. You only have n papers, so h ≤ n. That is why the counting array clamps at n.\nStep back to when you allowed h greater than n.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort descending and take the largest h with citations[h − 1] ≥ h. Or bucket min(cite, n) and accumulate down. Not an average, not exactly h, not 275’s binary search on an unsorted array.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
