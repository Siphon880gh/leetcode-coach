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
            'message' => "Problem: s is a valid NestedInteger serialization (digits, minus, commas, brackets). Return a NestedInteger: one integer or a list of NestedIntegers. \"324\" → integer 324. \"[123,[456,[789]]]\" → a list holding 123 and a nested list. \"[]\" is an empty list.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'eval / json.loads, or split on every comma without tracking brackets', 'next' => 'wrong_eval'],
                ['label' => 'If s has no [, parse an integer; else split only top-level commas (or use a stack)', 'next' => 'rec'],
            ],
        ],
        'wrong_eval' => [
            'message' => "You are wrong here. eval / json.loads is not the intended parser (nested lists are not JSON objects). Blind split on commas breaks [123,[456]] because the inner comma is not a sibling cut.\nStep back to when you used eval or split without depth.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'rec' => [
            'message' => "No leading [: NestedInteger(int(s)), including negatives. \"[]\" is an empty list, not 0. Otherwise walk from index 1 with a depth of extra open brackets. When depth is 0 and you see a comma or the last character, the slice [j, i) is one child — deserialize it and add it. [ / ] bump depth so inner commas stay inside the child.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat [] as the integer 0, or drop the minus on -12', 'next' => 'wrong_empty'],
                ['label' => 'Empty list stays a list. Keep the minus. Only cut when depth is 0', 'next' => 'stk'],
            ],
        ],
        'wrong_empty' => [
            'message' => "You are wrong. \"[]\" is an empty NestedInteger list. \"-12\" is the integer -12; dropping minus makes 12.\nStep back to when you mapped empty to 0 or ignored minus.",
            'outcome' => 'wrong',
            'rewind_to' => 'rec',
            'choices' => [],
        ],
        'stk' => [
            'message' => "Stack twin: push a new list on [. Accumulate digits into x (if you saw minus, negate when you flush). On comma or ] flush a finished number into the top frame. On ] with more than one frame, pop that list and add it to the parent. Nested List Weight Sum (339) and II (364) already have a NestedInteger tree; this problem builds that tree from text.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Build the tree from text. 324 is the integer 324. Not 339 / 364', 'next' => 'success'],
                ['label' => 'Assume NestedInteger is already built (339), or skip popping lists on ]', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. 339 and 364 consume an existing NestedInteger. If you never pop on ], nested lists never attach to their parent.\nStep back to when you reused 339 or skipped the pop.",
            'outcome' => 'wrong',
            'rewind_to' => 'stk',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Recurse on top-level slices, or stack-parse. \"324\" → 324. \"[123,[456,[789]]]\" nests. Not eval. Not 339.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
