<?php
declare(strict_types=1);

return [
    'title' => 'Rank Scores: DENSE_RANK, ties share, no holes',
    'leetcode' => 178,
    'summary' => 'Score descending. Equal scores same rank. Next rank is the next integer, not RANK-style gaps. DENSE_RANK OVER (ORDER BY score DESC). Quote rank; it is reserved.',
    'category' => 'LeetCode',
    'subcategory' => 'Database',
    'topic' => 'LeetCode · Database',
    'kind' => 'algo',
    'tags' => ['database', 'sql', 'window-function', 'leetcode'],
    'related_session' => 'rank-scores',
];
