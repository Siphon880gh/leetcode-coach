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
            'message' => "Problem: NumMatrix on an immutable grid. sumRegion(row1, col1, row2, col2) inclusive, O(1) per call. Sample sumRegion(2,1,4,3) → 8. Up to 200 by 200, 10^4 queries.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '1-D prefix per row (303) looping rows, or Fenwick because 307 exists', 'next' => 'wrong_kind'],
                ['label' => 'Pad a 2-D prefix with a dummy border; query with include-exclude', 'next' => 'prefix'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong here.\nA 1-D prefix per row is O(m) per query. Fenwick is for updates. This matrix never changes and the spec is O(1).\nStep back to when you reused 303 or 307.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'prefix' => [
            'message' => "s is (m+1) by (n+1) zeros. s[i+1][j+1] = s[i][j+1] + s[i+1][j] − s[i][j] + matrix[i][j]. Rectangle (r1,c1)–(r2,c2) is s[r2+1][c2+1] − s[r2+1][c1] − s[r1][c2+1] + s[r1][c1].\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Drop the + s[r1][c1] (the corner you subtracted twice)', 'next' => 'wrong_corner'],
                ['label' => 'Dummy zeros make r1 == 0 or c1 == 0 just work. O(m n) build, O(1) query', 'next' => 'cpx'],
            ],
        ],
        'wrong_corner' => [
            'message' => "You are wrong. Both strips include the top-left block. You must add s[r1][c1] back.\nStep back to when you double-subtracted.",
            'outcome' => 'wrong',
            'rewind_to' => 'prefix',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Do not scan the rectangle at query time. Inclusive corners. Negative cells are fine.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '2-D pad prefix, include-exclude plus corner. Not 303, not Fenwick, not a nested loop', 'next' => 'success'],
                ['label' => 'sumRegion is exclusive on row2/col2, like a Python slice', 'next' => 'wrong_excl'],
            ],
        ],
        'wrong_excl' => [
            'message' => "You are wrong. The rectangle includes (row2, col2).\nStep back to when you treated the far corner as exclusive.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Pad s. Build with above + left − overlap + cell. Query subtracts two strips and adds the corner back. O(1). Sample (2,1)–(4,3) is 8.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
