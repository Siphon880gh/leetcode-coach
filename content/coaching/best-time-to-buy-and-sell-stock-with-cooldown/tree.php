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
            'message' => "Problem: daily prices. Unlimited buy/sell, one share at a time, cooldown: after you sell you cannot buy the next day. [1,2,3,0,2] → 3 (buy, sell, cooldown, buy, sell). [1] → 0. Length up to 5000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stock II (122): sell and buy on consecutive days, or Stock I one trade', 'next' => 'wrong_ii'],
                ['label' => 'Memo dfs(i, holding): skip, buy, or sell then jump to i+2', 'next' => 'dfs'],
            ],
        ],
        'wrong_ii' => [
            'message' => "You are wrong here.\n122 allows sell then buy tomorrow. 121 is one trade. Here a rest day follows every sell.\nStep back to when you reused Stock I or II.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'dfs' => [
            'message' => "Past the end → 0. Always skip dfs(i+1, same hold). If holding, sell: prices[i] plus dfs(i+2, 0). If not holding, buy: minus prices[i] plus dfs(i+1, 1). Answer dfs(0, 0). Bottom-up: cash vs hold; a buy uses cash from two days back (or minus prices[i] on day 1).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Hold two shares, or sell then buy tomorrow like 122', 'next' => 'wrong_hold'],
                ['label' => 'O(n) time. Table O(n) or three rolling integers', 'next' => 'cpx'],
            ],
        ],
        'wrong_hold' => [
            'message' => "You are wrong. One share at a time. After a sell the next buy is two days later, not tomorrow.\nStep back to when you skipped the cooldown.",
            'outcome' => 'wrong',
            'rewind_to' => 'dfs',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Do not skip the i+2 jump after a sell. Rolling cash/hold/prev-cash is enough.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Sell then skip a day. Not Stock II consecutive buy-after-sell', 'next' => 'success'],
                ['label' => 'Cooldown means you must wait two days after a buy, not after a sell', 'next' => 'wrong_when'],
            ],
        ],
        'wrong_when' => [
            'message' => "You are wrong. The rest day is after a sell. You may sell the day after a buy.\nStep back to when you attached cooldown to the buy.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. After a sell, jump i+2 to buy again. Cash vs hold; buy reads two days back. [1,2,3,0,2] is 3. Not 122.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
