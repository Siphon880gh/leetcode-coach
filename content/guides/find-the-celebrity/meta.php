<?php
declare(strict_types=1);

return [
    'title' => 'Find the Celebrity: eliminate with knows(), then verify the candidate',
    'leetcode' => 277,
    'summary' => 'A celebrity is known by everyone and knows nobody. Walk i from 1: if the current candidate knows i, switch to i. Then check that the survivor knows nobody and everyone knows them. Else −1. Do not skip the verify pass.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'two-pointers', 'interactive', 'leetcode'],
    'related_session' => 'find-the-celebrity',
];
