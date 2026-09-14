<?php
declare(strict_types=1);

return [
    'title' => 'Perfect Rectangle: area plus corner counts',
    'leetcode' => 391,
    'summary' => 'Axis-aligned rectangles. True iff they exact-cover one big rectangle (no gaps, no overlaps). Sum of areas must equal the bounding box. Count each corner: the four bounding corners appear once; every other point appears 2 or 4 times. Area alone is not enough. Not 223 (union of two).',
    'category' => 'LeetCode',
    'subcategory' => 'Geometry',
    'topic' => 'LeetCode · Geometry',
    'kind' => 'algo',
    'tags' => ['geometry', 'hash-table', 'math', 'leetcode'],
    'related_session' => 'perfect-rectangle',
];
