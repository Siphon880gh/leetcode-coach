<?php
declare(strict_types=1);

return [
    'title' => 'Design Phone Directory: set of free slots',
    'leetcode' => 379,
    'summary' => 'maxNumbers slots 0..n−1. get pops any free number or −1. check is membership. release puts a number back (already-free is a no-op). max=3: get, get, check(2) true, get, check(2) false, release(2), check(2) true. Do not scan 0..n on every get.',
    'category' => 'LeetCode',
    'subcategory' => 'Design',
    'topic' => 'LeetCode · Design',
    'kind' => 'algo',
    'tags' => ['design', 'hash-set', 'queue', 'leetcode'],
    'related_session' => 'design-phone-directory',
];
