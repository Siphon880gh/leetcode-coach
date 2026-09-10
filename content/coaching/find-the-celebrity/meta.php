<?php
declare(strict_types=1);

return [
    'title' => 'Find the Celebrity: eliminate with knows(), then verify the candidate',
    'leetcode' => 277,
    'summary' => 'Walk a deterministic path: if the current candidate knows i, switch to i. Then check that the survivor knows nobody and everyone knows them. Else −1. Do not skip the verify pass. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'tags' => ['graphs', 'two-pointers', 'interactive', 'step-by-step'],
    'related_guide' => 'find-the-celebrity',
];
