<?php
declare(strict_types=1);

return [
    'title' => 'Queue Reconstruction by Height: tallest first, insert at k',
    'leetcode' => 406,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: sort by height descending, then k ascending. Insert each person at index k in a growing list. Taller people already sit in the list, so k counts how many of them stand in front. [[7,0],[4,4],[7,1],[5,0],[6,1],[5,2]] → [[5,0],[7,0],[5,2],[6,1],[4,4],[7,1]]. Not sort-by-k only. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Greedy',
    'topic' => 'LeetCode · Greedy',
    'tags' => ['greedy', 'sorting', 'arrays', 'step-by-step'],
    'related_guide' => 'queue-reconstruction-by-height',
];
