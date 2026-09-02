<?php
declare(strict_types=1);

/**
 * Step-by-step tree contract:
 * - start: node id
 * - nodes[id]: message, outcome (continue|wrong|success), choices[{label, next}], optional rewind_to on wrong
 */
return [
    'start' => 'start',
    'nodes' => [
        'start' => [
            'message' => "Problem: height = [1, 8, 6, 2, 5, 4, 8, 3, 7]. Pick two lines that form a container with the x-axis (no slant). Max water is 49.\nn can be 10⁵. What do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Try every pair of indices and take the max area', 'next' => 'brute'],
                ['label' => 'Start at both ends; always move the shorter pointer', 'next' => 'pointers'],
            ],
        ],
        'brute' => [
            'message' => "Every pair is O(n²) — too slow for 10⁵. Area is min(height[l], height[r]) × (r − l).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Move both pointers inward every step so the scan is linear', 'next' => 'wrong_both'],
                ['label' => 'Two pointers from the ends; only the shorter side can improve the min height', 'next' => 'pointers'],
            ],
        ],
        'wrong_both' => [
            'message' => "You are wrong here.\nMoving both skips candidates. One pointer stays; you only abandon the side that is currently the bottleneck.\nStep back to when you chose how to scan.",
            'outcome' => 'wrong',
            'rewind_to' => 'brute',
            'choices' => [],
        ],
        'pointers' => [
            'message' => "l = 0, r = n−1. Record area, then if height[l] < height[r] do l++, else r--.\nWhy move the shorter wall, not the taller?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Width always drops by 1; only a taller min-height can compensate, so drop the short wall', 'next' => 'example'],
                ['label' => 'Move the taller wall so the remaining gap still uses the high line', 'next' => 'wrong_tall'],
            ],
        ],
        'wrong_tall' => [
            'message' => "You are wrong. Height is the min of the two. Keeping the short wall caps every future area with that short height and a smaller width.\nStep back to when you chose which pointer to move.",
            'outcome' => 'wrong',
            'rewind_to' => 'pointers',
            'choices' => [],
        ],
        'example' => [
            'message' => "For [1,8,6,2,5,4,8,3,7], the best pair is height 8 at index 1 and height 7 at index 8: min(8,7)×7 = 49.\n[1,1] is just 1. What do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The max area seen while l < r — O(n) time, O(1) space', 'next' => 'success'],
                ['label' => 'The sum of all heights — water stacks on every bar', 'next' => 'wrong_sum'],
            ],
        ],
        'wrong_sum' => [
            'message' => "You are wrong. This is not a histogram-volume problem. One container: two lines and the x-axis, area = min height × width.\nStep back to when you scored a pair.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Two pointers from the ends; area = min(h[l], h[r]) × (r−l); move the shorter index. Time O(n), space O(1).\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
