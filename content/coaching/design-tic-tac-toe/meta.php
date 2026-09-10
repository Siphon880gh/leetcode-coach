<?php
declare(strict_types=1);

return [
    'title' => 'Design Tic-Tac-Toe: count rows, cols, and two diagonals',
    'leetcode' => 348,
    'summary' => 'Walk a deterministic path: n by n board. move(row, col, player) is valid and unique. Increment that player’s row, column, and diagonals (row==col; row+col==n−1). Win when any of those hits n. O(1) per move, not a full-board scan. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'matrix', 'counting', 'step-by-step'],
    'related_guide' => 'design-tic-tac-toe',
];
