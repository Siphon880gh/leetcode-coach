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
            'message' => "Problem: rewrite nums in place as the next lexicographic permutation. [1,2,3] → [1,3,2]. [2,3,1] → [3,1,2]. [3,2,1] → [1,2,3] (wrap to sorted). Constant extra memory. n ≤ 100.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Generate every permutation, sort them, pick the one after nums', 'next' => 'all'],
                ['label' => 'Find the rightmost ascent, swap with the next larger suffix value, reverse the tail', 'next' => 'pivot'],
            ],
        ],
        'all' => [
            'message' => "Listing n! permutations uses extra memory the problem forbids, even at n = 100.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Reverse the whole array every time — that always produces a different perm', 'next' => 'wrong_rev'],
                ['label' => 'Scan from the right for the first i with nums[i] < nums[i+1] (the pivot)', 'next' => 'pivot'],
            ],
        ],
        'wrong_rev' => [
            'message' => "You are wrong here.\n[1,2,3] reversed is [3,2,1], not the next perm [1,3,2]. Reverse only the descending suffix after the swap.\nStep back to when you chose the in-place move.",
            'outcome' => 'wrong',
            'rewind_to' => 'all',
            'choices' => [],
        ],
        'pivot' => [
            'message' => "If no such i exists, nums is fully non-increasing: last perm, reverse the whole array. Otherwise pick j from the right with nums[j] > nums[i]. Why the first such j from the right, not the suffix max?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The suffix is non-increasing, so the rightmost nums[j] > nums[i] is the smallest successor', 'next' => 'example'],
                ['label' => 'Swap i with the maximum in the suffix so the prefix jumps as far as possible', 'next' => 'wrong_max'],
            ],
        ],
        'wrong_max' => [
            'message' => "You are wrong. [1,3,2]: pivot 1, suffix max is 3, swap gives [3,1,2], but the next perm is [2,1,3]. You want the smallest value strictly larger than the pivot.\nStep back to when you chose j.",
            'outcome' => 'wrong',
            'rewind_to' => 'pivot',
            'choices' => [],
        ],
        'example' => [
            'message' => "[2,3,1]: i = 0 (2 < 3). From the right, 3 > 2, swap → [3,2,1], reverse after i → [3,1,2]. After the swap the suffix is still non-increasing, so reverse (not a full sort) makes it the smallest tail.\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(n) time, O(1) extra space', 'next' => 'success'],
                ['label' => 'O(n log n) because the suffix must be sorted with a comparison sort', 'next' => 'wrong_sort'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong. A descending suffix reversed is already sorted ascending. Two pointers suffice.\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Rightmost ascent i. If none, reverse all. Else swap with the rightmost nums[j] > nums[i], then reverse nums[i+1:]. Time O(n), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
