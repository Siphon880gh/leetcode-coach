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
            'message' => "Problem: 2 to 2000 strictly increasing stone positions, stones[0]=0, values up to 2^31−1. Frog starts on stone 0. First jump must be 1. If the last jump was k, the next is k−1, k, or k+1, only forward, and must land on a stone. Can it reach the last stone? [0,1,3,5,6,8,12,17] true. [0,1,2,3,4,8,9,11] false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat this as Jump Game (55): from i you may jump any 1..k freely', 'next' => 'wrong_55'],
                ['label' => 'State is (stone index, last jump k). Next jumps are only k−1, k, k+1', 'next' => 'dfs'],
            ],
        ],
        'wrong_55' => [
            'message' => "You are wrong here. 55 lets you jump any distance up to nums[i]. Here the next distance is forced to a 3-wide window around the last k, and missing stones are water.\nStep back to when you used Jump Game rules.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Map position to index. dfs(i, k) is true if you can finish from index i after arriving with jump k. Try j in {k−1, k, k+1} with j>0; if stones[i]+j is a stone, recurse. Memo (i, k). Start dfs(0, 0): the only positive j is 1, which is the required first jump.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Allow j=0 (stay) or jump backward, or skip the position map and scan the list each time', 'next' => 'wrong_zero'],
                ['label' => 'j must be positive. Hash the stone positions. Memo so n=2000 finishes', 'next' => 'kind'],
            ],
        ],
        'wrong_zero' => [
            'message' => "You are wrong. The frog only moves forward. j=0 is not a jump. Scanning 2000 stones per try without a map is too slow, and without memo you re-branch exponentially.\nStep back to when you allowed stay/back or skipped the map and memo.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'kind' => [
            'message' => "In the false example the gap 4→8 is 4, but you arrive at 4 with k=1, so next is only 1 or 2. Frog Jump II (2498) is a different cost problem.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Memo dfs(i, k). First jump 1. [0,1,3,5,6,8,12,17] true. Not 55', 'next' => 'success'],
                ['label' => 'Require every gap to equal the previous k, or start with an arbitrary first jump', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. k can grow (1 then 2 then 3…). The first jump is fixed at 1; if stones[1] is not 1, the frog fails immediately.\nStep back to when you froze k or allowed a first jump other than 1.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Last jump k, next k−1 / k / k+1 onto a stone. Memo dfs(i, k). First jump 1. Not 55.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
