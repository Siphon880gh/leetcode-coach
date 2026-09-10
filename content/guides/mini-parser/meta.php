<?php
declare(strict_types=1);

return [
    'title' => 'Mini Parser: deserialize NestedInteger from a string',
    'leetcode' => 385,
    'summary' => 's is a valid NestedInteger serialization: a bare integer or a bracketed list. Recurse: if no [, return NestedInteger(int(s)). Else split top-level commas (depth 0) and deserialize each slice. Stack twin: push on [, parse digits (watch minus), on comma or ] add the number, on ] pop into the parent. Not eval. Not 339/364 (those consume NestedInteger).',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'kind' => 'algo',
    'tags' => ['stack', 'dfs', 'string', 'nested-list', 'leetcode'],
    'related_session' => 'mini-parser',
];
