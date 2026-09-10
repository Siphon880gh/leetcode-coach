<?php
declare(strict_types=1);

return [
    'title' => 'Best Time to Buy and Sell Stock with Cooldown: sell then skip a day',
    'leetcode' => 309,
    'summary' => 'Walk a deterministic path: unlimited trades, but after a sell you cannot buy the next day. dfs(i, holding): skip, buy, or sell then jump i+2. Iterative: cash vs hold; a buy reads cash from two days back. [1,2,3,0,2] → 3. Not Stock II. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'stock', 'state-machine', 'step-by-step'],
    'related_guide' => 'best-time-to-buy-and-sell-stock-with-cooldown',
];
