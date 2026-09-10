<?php
declare(strict_types=1);

return [
    'title' => 'Peeking Iterator: cache one next without advancing twice',
    'leetcode' => 284,
    'summary' => 'Walk a deterministic path: wrap an iterator. peek pulls iterator.next once and stores it. next returns that stash (or a fresh next). hasNext is true if a stash exists or the inner iterator still has items. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'tags' => ['design', 'iterator', 'step-by-step'],
    'related_guide' => 'peeking-iterator',
];
