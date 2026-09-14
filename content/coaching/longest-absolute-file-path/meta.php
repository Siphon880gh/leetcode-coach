<?php
declare(strict_types=1);

return [
    'title' => 'Longest Absolute File Path: indent stack of prefix lengths',
    'leetcode' => 388,
    'difficulty' => 'Med',
    'summary' => 'Walk a deterministic path: input is a newline/tab tree. Depth = leading tabs. Stack stores the absolute length of each directory prefix. A name with a dot is a file: parent length plus one slash plus name length; keep the max. Directories push; no file → 0. dir/subdir2/file.ext is 20. Do not count a directory as a file. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'tags' => ['stack', 'strings', 'dfs', 'step-by-step'],
    'related_guide' => 'longest-absolute-file-path',
];
