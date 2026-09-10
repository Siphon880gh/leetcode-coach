<?php
declare(strict_types=1);

return [
    'title' => 'Zigzag Iterator: cycle through lists; skip a list that is spent',
    'leetcode' => 281,
    'summary' => 'Walk a deterministic path: next/hasNext over v1 and v2 alternately. One index per list and a current list id. hasNext skips spent lists; wrap to start means empty. Not Flatten 2D Vector. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'queue', 'iterator', 'step-by-step'],
    'related_guide' => 'zigzag-iterator',
];
