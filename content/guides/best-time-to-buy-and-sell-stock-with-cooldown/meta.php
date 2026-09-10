<?php
declare(strict_types=1);

return [
    'title' => 'Best Time to Buy and Sell Stock with Cooldown: sell then skip a day',
    'leetcode' => 309,
    'summary' => 'Unlimited trades, but after a sell you cannot buy the next day. dfs(i, holding): skip, buy, or sell then jump i+2. Iterative: cash vs hold; a buy reads cash from two days back. [1,2,3,0,2] → 3. Not Stock II.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'stock', 'state-machine', 'leetcode'],
    'related_session' => 'best-time-to-buy-and-sell-stock-with-cooldown',
];
