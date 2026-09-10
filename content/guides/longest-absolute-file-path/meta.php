<?php
declare(strict_types=1);

return [
    'title' => 'Longest Absolute File Path: indent stack of prefix lengths',
    'leetcode' => 388,
    'summary' => 'input is a newline/tab tree. Depth = leading tabs. Stack stores the absolute length of each directory prefix. A name with a dot is a file: parent length + 1 (slash) + name length; keep the max. Directories push; no file → 0. dir/subdir2/file.ext is 20. Do not count a directory as a file.',
    'category' => 'LeetCode',
    'subcategory' => 'Stack',
    'topic' => 'LeetCode · Stack',
    'kind' => 'algo',
    'tags' => ['stack', 'strings', 'dfs', 'leetcode'],
];
