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
            'message' => "Problem: same ++ to -- flips as Flip Game. No move loses. True iff the starting player can force a win. ++++ → true (middle cut to +--+). + → false. Length up to 60, at most 20 consecutive pluses.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Only list one-move strings (Flip Game) or count ++ windows', 'next' => 'wrong_list'],
                ['label' => 'You win if some move leaves a losing board for the opponent', 'next' => 'dfs'],
            ],
        ],
        'wrong_list' => [
            'message' => "You are wrong here.\nListing children is Flip Game. An odd number of windows is not a win: overlapping ++ share pluses.\nStep back to when you stopped at one layer or counted windows.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Encode pluses as bits of mask. dfs(mask): for each i with bits i and i+1 set, XOR those bits off and recurse. If that child is false, return true. No such child → false. Cache mask.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip the memo; n can be 60', 'next' => 'wrong_memo'],
                ['label' => 'Memoized search. ++++ wins via the middle pair', 'next' => 'cpx'],
            ],
        ],
        'wrong_memo' => [
            'message' => "You are wrong. Without a cache the same board is searched many times. Memoize mask.\nStep back to when you skipped the cache.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Nim Game is a different heap. This is impartial: you win iff a losing reply exists.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Exists a move to a false dfs. Not listing, not window-count', 'next' => 'success'],
                ['label' => '++++ is false because the opponent always has a reply', 'next' => 'wrong_sample'],
            ],
        ],
        'wrong_sample' => [
            'message' => "You are wrong. Flip the middle ++ to +--+. The opponent has no ++ left, so you win.\nStep back to when you scored ++++.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Memoized DFS: win if any flip leaves a losing position. ++++ is true. Not Flip Game listing. Cache the mask.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
