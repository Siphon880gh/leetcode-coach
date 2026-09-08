<?php
declare(strict_types=1);

return [
    'title' => 'The Skyline Problem: sweep x, emit when max height changes',
    'leetcode' => 218,
    'summary' => 'Sort every left and right x. At each x, push buildings that start, drop those that ended, then take the live max height. Append [x, h] only when h differs from the last key point.',
    'category' => 'LeetCode',
    'subcategory' => 'Sweep Line',
    'topic' => 'LeetCode · Sweep Line',
    'kind' => 'algo',
    'tags' => ['sweep-line', 'heap', 'sorting', 'leetcode'],
    'related_session' => 'the-skyline-problem',
];
