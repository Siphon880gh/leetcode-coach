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
            'message' => "Problem: n people, 1 to 2000. Each is [h, k]: height h, and exactly k people in front with height ≥ h. Reconstruct the queue. [[7,0],[4,4],[7,1],[5,0],[6,1],[5,2]] → [[5,0],[7,0],[5,2],[6,1],[4,4],[7,1]]. Guaranteed possible.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sort by k only, or place shortest people first so later taller inserts do not move them', 'next' => 'wrong_sort'],
                ['label' => 'Sort tallest first (same height: smaller k first). Then insert each at index k', 'next' => 'insert'],
            ],
        ],
        'wrong_sort' => [
            'message' => "You are wrong here. k is a count of taller-or-equal people, not a final index by itself. Shortest-first insertion would shove shorter people around when a taller person later lands in front, breaking their k.\nStep back to when you sorted by k only or placed shortest first.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'insert' => [
            'message' => "After sorting, the list only contains people already placed who are at least as tall as the one you are inserting (or taller). So empty slots in front of index k are later filled by shorter people, who do not change this person’s k. insert(k, person) is O(n) each; n=2000 is fine.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Append to the end, or overwrite index k instead of inserting (shifting the rest right)', 'next' => 'wrong_append'],
                ['label' => 'Insert at k so later shorter people can land in front without changing this k', 'next' => 'kind'],
            ],
        ],
        'wrong_append' => [
            'message' => "You are wrong. Appending ignores k. Overwriting drops whoever was already at that index. Insertion opens a slot; people already in the list slide right, which is correct because they are taller and their k still holds.\nStep back to when you appended or overwrote.",
            'outcome' => 'wrong',
            'rewind_to' => 'insert',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Sample: place [7,0] then [7,1] then [6,1] then [5,0] then [5,2] then [4,4] and you get the output. Candy (135) is a different two-pass greedy. Queue Reconstruction is not a Fenwick requirement unless you optimize insert.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Tallest first, insert at k. Sample reconstructs to [[5,0],[7,0],[5,2],[6,1],[4,4],[7,1]]', 'next' => 'success'],
                ['label' => 'Sort height ascending, or treat k as how many shorter people must stand in front', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. k counts taller or equal, not shorter. Height must go descending so the people already in the list are the only ones that count for k.\nStep back to when you sorted shortest-first or counted shorter people.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Sort height descending, k ascending. Insert each person at index k. Taller people already sit in the list. Not sort-by-k only.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
