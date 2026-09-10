<?php
declare(strict_types=1);

return [
    'title' => 'Sparse Matrix Multiplication: skip zeros when adding products',
    'leetcode' => 311,
    'summary' => 'Walk a deterministic path: mat1 is m by k, mat2 is k by n. ans[i][j] is the dot of row i and column j. Compress each row to (col, val) pairs of nonzeros; for (k, x) in row i of mat1, add x times y into ans[i][j] for each (j, y) in row k of mat2. Naive triple loop works but wastes zeros. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Arrays',
    'topic' => 'LeetCode · Arrays',
    'tags' => ['arrays', 'matrix', 'hash-table', 'step-by-step'],
    'related_guide' => 'sparse-matrix-multiplication',
];
