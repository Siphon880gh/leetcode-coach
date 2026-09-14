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
            'message' => "Problem: start with 1..n sorted. Delete every other value left to right, then right to left, and keep alternating until one number remains. n=9 → 6. n=1 → 1. n is up to 1e9.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Build a deque or list and simulate, or use one-direction Josephus (1823 / 2L+1)', 'next' => 'wrong_sim'],
                ['label' => 'Track the remaining head (and gap / count); n=1e9 forbids storing the list', 'next' => 'head'],
            ],
        ],
        'wrong_sim' => [
            'message' => "You are wrong here. A list of size 1e9 does not fit. 1823 is Josephus in one direction with a fixed k. The 2L+1 formula assumes every pass is left to right.\nStep back to when you simulated or used one-direction Josephus.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'head' => [
            'message' => "Survivors stay an arithmetic sequence: head, gap step, count remaining. A left-to-right pass always removes head, so head moves forward by step. A right-to-left pass removes head only when remaining is odd. Then remaining is halved and step doubles. Stop at remaining 1; the answer is head.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Skip moving head on an odd-length right-to-left pass', 'next' => 'wrong_odd'],
                ['label' => 'Move head on every LTR pass, and on RTL only when remaining is odd', 'next' => 'kind'],
            ],
        ],
        'wrong_odd' => [
            'message' => "You are wrong. When remaining is odd, a right-to-left every-other also hits the leftmost value, so head must advance.\nStep back to when you froze head on an odd RTL pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'head',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Keeping both ends a1 and an is the same: the end you scan from always moves by step; the other end moves only on an odd count. For n=9 the last remaining is 6, not 8.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Head plus gap. n=9 → 6. n=1 → 1. Not 1823', 'next' => 'success'],
                ['label' => 'Return 8 for n=9, or apply only left-to-right passes', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. After 1 3 5 7 9 go, then 4 and 8 go, then 2 goes: 6 remains. Skipping RTL passes is a different problem.\nStep back to when you dropped the RTL pass or guessed 8.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Track head, step, remaining. LTR always moves head; RTL moves it only on an odd count. n=9 → 6. Not 1823.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
