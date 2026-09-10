<?php
declare(strict_types=1);

return [
    'title' => 'Paint Fence: same-as-previous only if the last pair already differed',
    'leetcode' => 276,
    'summary' => 'Walk a deterministic path: n posts, k colors, no three consecutive the same. f = last two differ, g = last two match. Next different: (f+g)×(k−1). Next same: copy old f. Not Paint House’s min cost. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'tags' => ['dynamic-programming', 'step-by-step'],
    'related_guide' => 'paint-fence',
];
