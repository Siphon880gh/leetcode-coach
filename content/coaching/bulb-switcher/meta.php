<?php
declare(strict_types=1);

return [
    'title' => 'Bulb Switcher: on iff perfect square',
    'leetcode' => 319,
    'summary' => 'Walk a deterministic path: n bulbs start off; round i toggles every i-th. A bulb ends on iff it has an odd number of divisors, which happens only for perfect squares. Return floor(sqrt(n)). n = 3 → 1. n = 0 → 0. Wrong turns tell you when to step back.',
    'category' => 'LeetCode',
    'subcategory' => 'Math',
    'topic' => 'LeetCode · Math',
    'tags' => ['math', 'brainteaser', 'step-by-step'],
    'related_guide' => 'bulb-switcher',
];
