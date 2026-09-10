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
            'message' => "Problem: longest substring of s with at most k distinct characters. eceba, k=2 → 3 (ece). aa, k=1 → 2. k=0 → 0. Length up to 5e4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Check every substring, or restart the window at right when you exceed k', 'next' => 'wrong_brute'],
                ['label' => 'Sliding window: grow right; shrink left while the map has more than k keys', 'next' => 'window'],
            ],
        ],
        'wrong_brute' => [
            'message' => "You are wrong here. Every pair of indices is too slow at n=5e4. Restarting from right throws away leftover counts that can stay in the window.\nStep back to when you brute-forced or reset the window.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'window' => [
            'message' => "Increment cnt[s[right]]. While cnt has more than k keys, decrement cnt[s[left]], delete if the count hits 0, then left += 1. Then ans = max(ans, right − left + 1).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Require exactly k distinct, or treat this as 3 (no repeats)', 'next' => 'wrong_exact'],
                ['label' => 'At most k (fewer is allowed). 159 is this with k glued to 2', 'next' => 'cpx'],
            ],
        ],
        'wrong_exact' => [
            'message' => "You are wrong. At most k allows fewer distinct. 3 forbids repeats (each character at most once), a different constraint.\nStep back to when you required exactly k or reached for 3.",
            'outcome' => 'wrong',
            'rewind_to' => 'window',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "k=0 → 0 (empty is the only valid substring). Time O(n), space O(k). Doocs may shrink once per step and return n − left; that trick is length-only. Prefer the while + max length form.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Grow right, shrink while keys > k, record width. k=0 → 0', 'next' => 'success'],
                ['label' => 'Return k, or the count of distinct letters in the whole string', 'next' => 'wrong_k'],
            ],
        ],
        'wrong_k' => [
            'message' => "You are wrong. The judge wants the longest window width, not k itself and not how many distinct letters s has overall.\nStep back to when you returned k or the global distinct count.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Grow right; shrink while the map exceeds k; record right − left + 1. Not exactly k. Not 3.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
