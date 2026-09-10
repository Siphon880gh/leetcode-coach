<?php
declare(strict_types=1);

return [
    'title' => 'Mini Parser: deserialize NestedInteger from a string',
    'leetcode' => 385,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: s is a valid NestedInteger serialization. If no [, return NestedInteger(int(s)). Else split only top-level commas (depth 0) and deserialize each slice. Stack twin: push on [, parse digits (watch minus), on comma or ] add the number, on ] pop into the parent. Not eval. Not 339/364. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'tags' => ['stack', 'dfs', 'string', 'nested-list', 'step-by-step'],
    'related_guide' => 'mini-parser',
];
