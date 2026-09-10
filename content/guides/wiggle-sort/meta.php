<?php
declare(strict_types=1);

return [
    'title' => 'Wiggle Sort: one pass; swap when the adjacent pair breaks the wave',
    'leetcode' => 280,
    'summary' => 'Reorder in place so nums[0] ≤ nums[1] ≥ nums[2] ≤ …. At odd i, swap if nums[i] is smaller than the previous; at even i, swap if it is larger. O(n), not a full sort. Not Wiggle Sort II’s strict peaks.',
    'category' => 'LeetCode',
    'subcategory' => 'Greedy',
    'topic' => 'LeetCode · Greedy',
    'kind' => 'algo',
    'tags' => ['greedy', 'arrays', 'sorting', 'leetcode'],
    'related_session' => 'wiggle-sort',
];
