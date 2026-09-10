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
            'message' => "Problem: return the k most frequent values in nums, any order. The set is unique. [1,1,1,2,2,3], k=2 → [1,2]. Length up to 1e5. Follow-up: better than O(n log n).\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Kth Largest (215) on the values themselves, or return the k highest counts instead of the keys', 'next' => 'wrong_215'],
                ['label' => 'Count frequencies, then a min-heap of size k (or buckets by count)', 'next' => 'heap'],
            ],
        ],
        'wrong_215' => [
            'message' => "You are wrong here. 215 ranks values, not how often they appear. The answer is the keys (1 and 2), not the counts (3 and 2).\nStep back to when you reused 215 or returned counts.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'heap' => [
            'message' => "Map cnt[x] = how often x appears. Min-heap of (count, value): push each unique key; if the heap grows past k, pop the smallest count. What remains is the top k. Time O(n + u log k).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep a max-heap of every unique key, or sort all unique keys by count', 'next' => 'wrong_all'],
                ['label' => 'Evict the rarest so the heap stays size k. Buckets: walk frequency from n down, O(n)', 'next' => 'cpx'],
            ],
        ],
        'wrong_all' => [
            'message' => "You are wrong. A full sort is O(u log u) and misses the follow-up. A max-heap of everything is the same cost. Size-k min-heap (or buckets) is the point.\nStep back to when you kept every key on a heap or sorted them all.",
            'outcome' => 'wrong',
            'rewind_to' => 'heap',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "buckets[c] = values with frequency c (c at most n). Walk c from n down to 1 until you have k values. Any order among the k is fine. 692 adds lexicographic ties; this problem does not.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Count, min-heap k (or buckets). Return values. Not 215, not 692', 'next' => 'success'],
                ['label' => 'Assume a unique order among the k keys and sort the answer', 'next' => 'wrong_ord'],
            ],
        ],
        'wrong_ord' => [
            'message' => "You are wrong. The set is unique, but order among those k keys is free. Sorting the answer is extra work, not required.\nStep back to when you forced an order.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Count, then a min-heap of size k (evict the rarest), or bucket by frequency and walk from n down. Return the values. Not 215, not a full sort, not 692.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
