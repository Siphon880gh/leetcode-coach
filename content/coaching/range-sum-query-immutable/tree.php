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
            'message' => "Problem: NumArray on an immutable nums. Many sumRange(left, right) calls, inclusive. [-2,0,3,-5,2,-1] → (0,2)=1, (2,5)=-1, (0,5)=-3. Length and queries up to 10^4.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Fenwick / segment tree (307), or a 2-D prefix (304), or loop left..right each call', 'next' => 'wrong_kind'],
                ['label' => 'One 1-D prefix with a dummy 0: sum is s[right+1] minus s[left]', 'next' => 'prefix'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong here.\n307 is for updates. 304 is 2-D. Scanning the range each call is O(n) per query and fails 10^4 times 10^4.\nStep back to when you reused Fenwick, 2-D, or a live loop.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'prefix' => [
            'message' => "s[0] = 0, s[i+1] = s[i] + nums[i]. Inclusive [left, right] is s[right+1] − s[left]. The dummy slot makes sumRange(0, n−1) equal s[n] − s[0].\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Omit the dummy 0 and special-case left == 0, or store prefix without the extra slot', 'next' => 'wrong_off'],
                ['label' => 'O(n) build, O(1) per query. Array never updates', 'next' => 'cpx'],
            ],
        ],
        'wrong_off' => [
            'message' => "You are wrong. Keep s of length n+1 with s[0]=0. Then every query is the same subtraction, including left = 0.\nStep back to when you off-by-oned the prefix.",
            'outcome' => 'wrong',
            'rewind_to' => 'prefix',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Queries are inclusive. Negative values are allowed; prefix still works. Do not mutate nums after construct.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Prefix once, s[right+1] − s[left]. Not Fenwick, not 304, not a loop per call', 'next' => 'success'],
                ['label' => 'sumRange is exclusive on the right, like Python slices', 'next' => 'wrong_excl'],
            ],
        ],
        'wrong_excl' => [
            'message' => "You are wrong. The range is inclusive on both ends. right is in the sum.\nStep back to when you treated it as exclusive.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Dummy 0 prefix. Inclusive sum is s[right+1] minus s[left]. O(1) queries. Not 304, not 307.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
