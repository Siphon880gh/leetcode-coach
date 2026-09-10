<?php
declare(strict_types=1);

return [
    'title' => 'Zigzag Iterator: cycle through lists; skip a list that is spent',
    'leetcode' => 281,
    'summary' => 'next/hasNext over v1 and v2 alternately. Keep an index per list and a current list id. hasNext advances past exhausted lists; if you wrap to the start, there is nothing left. Follow-up: same cycle for k lists. Not Flatten 2D Vector’s row-major walk.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'queue', 'iterator', 'leetcode'],
    'related_session' => 'zigzag-iterator',
];
