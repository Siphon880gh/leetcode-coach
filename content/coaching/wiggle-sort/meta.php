<?php
declare(strict_types=1);

return [
    'title' => 'Wiggle Sort: one pass; swap when the adjacent pair breaks the wave',
    'leetcode' => 280,
    'summary' => 'Walk a deterministic path: reorder in place so nums[0] ≤ nums[1] ≥ nums[2] ≤ …. Odd i is a peak; even i is a valley. Swap the broken pair. O(n), not a full sort. Not Wiggle Sort II. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Greedy',
    'topic' => 'LeetCode · Greedy',
    'tags' => ['greedy', 'arrays', 'sorting', 'step-by-step'],
    'related_guide' => 'wiggle-sort',
];
