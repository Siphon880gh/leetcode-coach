<?php
declare(strict_types=1);

return [
    'title' => 'Paint Fence: same-as-previous only if the last pair already differed',
    'leetcode' => 276,
    'summary' => 'n posts, k colors, no three consecutive the same. f = ways the last two differ, g = ways they match. Next different: (f+g)×(k−1). Next same: copy old f. Answer f+g. Not Paint House’s min cost.',
    'category' => 'LeetCode',
    'subcategory' => 'Dynamic Programming',
    'topic' => 'LeetCode · Dynamic Programming',
    'kind' => 'algo',
    'tags' => ['dynamic-programming', 'leetcode'],
    'related_session' => 'paint-fence',
];
