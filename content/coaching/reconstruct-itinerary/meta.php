<?php
declare(strict_types=1);

return [
    'title' => 'Reconstruct Itinerary: Hierholzer from JFK, reverse the post-order',
    'leetcode' => 332,
    'summary' => 'Walk a deterministic path: use every ticket once from JFK. Among valid Eulerian paths, pick the lex-smallest airport sequence. Sort destinations reverse, DFS-pop unused edges, append after children, then reverse. Greedy “always next lex city” can get stuck. Not a shortest path. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Graphs',
    'topic' => 'LeetCode · Graphs',
    'tags' => ['graphs', 'eulerian-path', 'depth-first-search', 'step-by-step'],
    'related_guide' => 'reconstruct-itinerary',
];
