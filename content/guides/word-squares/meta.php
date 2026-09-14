<?php
declare(strict_types=1);

return [
    'title' => 'Word Squares: next row is the prefix already written down the column',
    'leetcode' => 425,
    'difficulty' => 'Hard',
    'summary' => 'Unique same-length words. A square is n rows where the k-th row equals the k-th column. Reuse a word is allowed. Trie of prefixes → word indexes. After placing some rows, the next prefix is the letters already sitting in that column. ["area","lead","wall","lady","ball"] → two squares. Not 422 (validate one square).',
    'category' => 'LeetCode',
    'subcategory' => 'Trie',
    'topic' => 'LeetCode · Trie',
    'kind' => 'algo',
    'tags' => ['trie', 'backtracking', 'strings', 'leetcode'],
];
