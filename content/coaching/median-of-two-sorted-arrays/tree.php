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
            'message' => "Problem: nums1 = [1, 3], nums2 = [2]. Return the median of the two already-sorted arrays.\nThe required time is O(log(m+n)). What do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Merge both arrays, then pick the middle index(es)', 'next' => 'merge'],
                ['label' => 'Find the k-th smallest across both arrays without merging', 'next' => 'kth_idea'],
            ],
        ],
        'merge' => [
            'message' => "A merge is O(m+n). That finds the median, but it misses the log bound.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Concatenate, sort, then pick the middle — still not O(log(m+n))', 'next' => 'wrong_concat'],
                ['label' => 'Binary-search the k-th element: discard k/2 candidates per step', 'next' => 'kth_idea'],
            ],
        ],
        'wrong_concat' => [
            'message' => "You are wrong here.\nSorting a copy is at best O((m+n) log(m+n)). The log bound needs you to throw away half of k without scanning everything.\nStep back to when you chose how to beat a linear merge.",
            'outcome' => 'wrong',
            'rewind_to' => 'merge',
            'choices' => [],
        ],
        'kth_idea' => [
            'message' => "If m+n is odd there is one middle; if even you average two. How do we unify that?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Average the ((m+n+1)//2)-th and ((m+n+2)//2)-th smallest', 'next' => 'discard'],
                ['label' => 'Always return nums1[(m+n)//2] because nums1 is sorted', 'next' => 'wrong_one_array'],
            ],
        ],
        'wrong_one_array' => [
            'message' => "You are wrong. The median is of the combined sequence, not an index in one array. [1,3] and [2] have median 2, which lives in nums2.\nStep back to when you defined which order statistics to fetch.",
            'outcome' => 'wrong',
            'rewind_to' => 'kth_idea',
            'choices' => [],
        ],
        'discard' => [
            'message' => "To get the k-th remaining value, compare each array’s (k//2)-th remaining element (treat a missing one as +∞). If nums1’s is smaller, what can you discard?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The first k//2 remaining elements of nums1 — they cannot be the k-th', 'next' => 'base'],
                ['label' => 'The second half of nums2 — smaller values must live there', 'next' => 'wrong_half'],
            ],
        ],
        'wrong_half' => [
            'message' => "You are wrong. If x ≤ y, nums1’s first k//2 values are too small to be the k-th, so you drop those and ask for the (k − k//2)-th in what remains.\nStep back to when you compared the two mid candidates.",
            'outcome' => 'wrong',
            'rewind_to' => 'discard',
            'choices' => [],
        ],
        'base' => [
            'message' => "Base cases: an empty remaining side → take the k-th from the other; k = 1 → min of the two heads.\nnums1 = [1,2], nums2 = [3,4]: fetch the 2nd and 3rd smallest (2 and 3). What is the median?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2.5 — average of 2 and 3', 'next' => 'success'],
                ['label' => '2 — only the lower middle counts', 'next' => 'wrong_even'],
            ],
        ],
        'wrong_even' => [
            'message' => "You are wrong. Even length uses both middles: (2+3)/2 = 2.5.\nStep back to when you combined the two order statistics.",
            'outcome' => 'wrong',
            'rewind_to' => 'base',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. k-th via divide and conquer: compare the k//2 candidates, discard that many, recurse. Odd and even unify as two k-th queries. Time O(log(m+n)).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
