<?php
declare(strict_types=1);

return [
    'title' => 'Reconstruct Itinerary: Hierholzer from JFK, reverse the post-order',
    'leetcode' => 332,
    'summary' => 'Use every ticket once. Start at JFK. Among valid Eulerian paths, pick the lex-smallest airport sequence. Sort destinations reverse, DFS-pop unused edges, append after children, then reverse. Greedy “always next lex city” can get stuck. Not a shortest path.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'kind' => 'algo',
    'tags' => ['graphs', 'eulerian-path', 'depth-first-search', 'leetcode'],
    'related_session' => 'reconstruct-itinerary',
];
