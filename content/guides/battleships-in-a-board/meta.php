<?php
declare(strict_types=1);

return [
    'title' => 'Battleships in a Board: count only the top-left X of each ship',
    'leetcode' => 419,
    'difficulty' => 'Med',
    'summary' => 'Ships are 1-by-k or k-by-1, never adjacent. Count an X only when the cell above is not X and the cell to the left is not X — that is the unique head. [["X",".",".","X"],[".",".",".","X"],[".",".",".","X"]] → 2. [["."]] → 0. One pass, O(1) extra, no board edits. Not 200 (islands).',
    'category' => 'LeetCode',
    'subcategory' => 'Matrix',
    'topic' => 'LeetCode · Matrix',
    'kind' => 'algo',
    'tags' => ['matrix', 'dfs', 'arrays', 'leetcode'],
];
