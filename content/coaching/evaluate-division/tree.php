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
            'message' => "Problem: equations[i] = [Ai, Bi] with Ai / Bi = values[i]. Queries ask Cj / Dj. Return −1.0 if a name never appeared or the two variables are disconnected. Input has no contradiction and no divide-by-zero. a/b=2, b/c=3 → a/c=6, b/a=0.5, a/e=−1, a/a=1, x/x=−1.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Unweighted union-find (same as Number of Provinces), or answer 1 for every x/x', 'next' => 'wrong_uf'],
                ['label' => 'Weighted union-find (or DFS on a ratio graph) so paths multiply', 'next' => 'wuf'],
            ],
        ],
        'wrong_uf' => [
            'message' => "You are wrong here. Connectivity alone cannot recover 2 times 3 = 6. And x/x is −1 when x never appeared in equations; only a known variable over itself is 1.\nStep back to when you dropped the weights or answered 1 for an unknown x/x.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'wuf' => [
            'message' => "w[x] is x over its parent. On find, compress and multiply w[x] by w[old parent] so it stays x over the new root. Union a/b=v by linking roots with w[pa] = w[b] times v over w[a]. Query c/d is w[c] / w[d] when find(c) equals find(d).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Add the edge values (2+3) instead of multiplying along the path', 'next' => 'wrong_add'],
                ['label' => 'Ratios compose by multiplying. Reverse of a/b=v is 1/v', 'next' => 'kind'],
            ],
        ],
        'wrong_add' => [
            'message' => "You are wrong. a/b=2 and b/c=3 means a/c = 6, not 5. Graph DFS multiplies edge weights the same way.\nStep back to when you added ratios instead of multiplying.",
            'outcome' => 'wrong',
            'rewind_to' => 'wuf',
            'choices' => [],
        ],
        'kind' => [
            'message' => "A missing variable is not in the parent map — do not insert it on query. Floyd on the dense ratio graph also works at this n (at most 20 equations).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Weighted UF. a/c=6. x/x=−1. Not unweighted connectivity', 'next' => 'success'],
                ['label' => 'Treat bc as b times c, or require integer answers only', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Names are opaque strings: bc is one variable, not a product. Answers are floats (0.5, 3.75).\nStep back to when you parsed names as algebra or required integers.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Weighted union-find along ratios. a/b=2, b/c=3 → a/c=6, b/a=0.5, x/x=−1.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
