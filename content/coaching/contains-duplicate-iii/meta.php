<?php
declare(strict_types=1);

return [
    'title' => 'Contains Duplicate III: window plus nearby values',
    'leetcode' => 220,
    'summary' => 'Walk a deterministic path: true if two indices are at most k apart and values differ by at most t. Keep the last k numbers in an ordered set and probe [v − t, v + t], or bucket by t + 1. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Sliding Window',
    'topic' => 'LeetCode · Sliding Window',
    'tags' => ['sliding-window', 'ordered-set', 'buckets', 'step-by-step'],
    'related_guide' => 'contains-duplicate-iii',
];
