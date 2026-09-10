<?php
declare(strict_types=1);

return [
    'title' => 'Peeking Iterator: cache one next without advancing twice',
    'leetcode' => 284,
    'summary' => 'Wrap an iterator. peek pulls iterator.next once and stores it. next returns that stash (or a fresh next). hasNext is true if a stash exists or the inner iterator still has items.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'iterator', 'leetcode'],
    'related_session' => 'peeking-iterator',
];
