<?php
declare(strict_types=1);

return [
    'title' => 'Game of Life: encode next state so neighbors still see old live',
    'leetcode' => 289,
    'summary' => 'Eight neighbors. Live dies unless 2 or 3 live neighbors; dead becomes live on exactly 3. Mark live→dead as 2 and dead→live as −1 so “> 0” still means originally live. Then map 2 to 0 and −1 to 1.',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'kind' => 'algo',
    'tags' => ['arrays', 'matrix', 'simulation', 'leetcode'],
    'related_session' => 'game-of-life',
];
