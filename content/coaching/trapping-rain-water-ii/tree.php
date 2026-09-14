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
            'message' => "Problem: m by n height map, sides 1 to 200. Return how much water the 2D elevation can trap. [[1,4,3,1,3,2],[3,2,1,3,2,4],[2,3,3,2,3,1]] → 4. The other sample of a 3-ring around a 1 traps 10.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Run 1D Trapping Rain Water (42) on every row and every column and add them', 'next' => 'wrong_42'],
                ['label' => 'Water escapes over the lowest surrounding wall. Start a min-heap on the border', 'next' => 'heap'],
            ],
        ],
        'wrong_42' => [
            'message' => "You are wrong here. Row-plus-column 1D double-counts and also traps water that can drain diagonally around a wall. 42 is a 1D two-pointer; this is a 2D lowest-wall search.\nStep back to when you stacked 1D answers.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'heap' => [
            'message' => "Mark all border cells visited and push (height, i, j) into a min-heap. Repeat: pop the lowest wall h. For each unseen neighbor, add max(0, h − cell) to the answer, mark visited, and push (max(h, cell), x, y) so a taller cell becomes the new wall for cells behind it.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Use a max-heap, or start from interior cells, or skip marking visited so cells re-enter', 'next' => 'wrong_max'],
                ['label' => 'Always expand the current lowest wall. Visited once. Push max(h, cell) as the new wall', 'next' => 'kind'],
            ],
        ],
        'wrong_max' => [
            'message' => "You are wrong. A max-heap expands the tallest rim first and under-fills. Interior starts leak off the map. Re-visiting a cell double-counts water.\nStep back to when you used a max-heap, started inside, or skipped visited.",
            'outcome' => 'wrong',
            'rewind_to' => 'heap',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Pacific Atlantic (417) is reachability from two oceans, not water volume. Container With Most Water (11) is 1D area between two lines. Time is O(mn log mn).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Min-heap from the boundary inward. Water = max(0, wall − height). Sample → 4. Not 42', 'next' => 'success'],
                ['label' => 'Fill until the global max height, or treat the border as able to hold water too', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Water on the border always drains off the map. You never fill a cell above the lowest wall that currently contains it.\nStep back to when you filled to the global max or trapped water on the border.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Min-heap from the boundary inward. Water is max(0, wall − height). Re-push max(wall, cell). Not 42.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
