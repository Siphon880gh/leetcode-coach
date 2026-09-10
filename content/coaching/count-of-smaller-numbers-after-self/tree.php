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
            'message' => "Problem: counts[i] is how many later values are strictly smaller than nums[i]. [5,2,6,1] → [2,1,1,0]. [-1] → [0]. [-1,-1] → [0,0] (equals do not count). Length up to 1e5; values in [-1e4, 1e4].\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Nested scan of j > i, or count smaller values anywhere in nums', 'next' => 'wrong_scan'],
                ['label' => 'Walk right to left. Rank-compress. Fenwick frequencies of seen ranks', 'next' => 'fenwick'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong here.\nA nested loop is O(n²) and fails 1e5. Counting smaller anywhere (left included) is a different problem.\nStep back to when you scanned every later index or the whole array.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'fenwick' => [
            'message' => "Sort unique values; map each to a 1-based rank. Walk nums from the right. Let x be the current rank. query(x minus 1) is how many already-inserted values (to the right) have a smaller rank. Then update(x, 1). Reverse the collected answers. Equals share a rank, so query(x minus 1) skips them.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Insert then query(x) (counts yourself), or Fenwick raw values with no ranks', 'next' => 'wrong_self'],
                ['label' => 'O(n log n). Merge-sort index inversions is the twin', 'next' => 'cpx'],
            ],
        ],
        'wrong_self' => [
            'message' => "You are wrong. query(x) after insert includes the current point. Raw values can be negative; ranks are 1-based unique order.\nStep back to when you counted yourself or skipped compression.",
            'outcome' => 'wrong',
            'rewind_to' => 'fenwick',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "307 Fenwick sums values; here the tree stores frequencies. Not 493 (reverse pairs with 2×). Not 327 (range-sum count).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Right to left, query ranks below you, then insert. Not a nested scan', 'next' => 'success'],
                ['label' => 'Count smaller to the left (j < i), like a prefix inversion table', 'next' => 'wrong_left'],
            ],
        ],
        'wrong_left' => [
            'message' => "You are wrong. The problem is later indices only. Sample 1: to the right of 5 there are 2 and 1, not a left prefix.\nStep back to when you counted the left side.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Rank-compress. Walk from the right. query(rank minus 1), then insert 1 at rank. Reverse. O(n log n). Not a nested scan.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
