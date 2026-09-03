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
            'message' => "Problem: Unix absolute path to canonical form. \"/home/\" → \"/home\". \"/home//foo/\" → \"/home/foo\". \"/../\" → \"/\". \"/.../a/../b/c/../d/.\" → \"/.../b/d\". Length ≤ 3000.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Regex: collapse slashes and strip a trailing slash; leave .. and . in the string', 'next' => 'regex'],
                ['label' => 'Split on /; skip empty and .; pop on .. if the stack is nonempty; else push; join under a leading /', 'next' => 'stk'],
            ],
        ],
        'regex' => [
            'message' => "Collapsing slashes does not apply \"..\". From root, \"/../\" must stay \"/\". \"...\" is a real directory name, not parent.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Treat every run of dots as parent directories', 'next' => 'wrong_dots'],
                ['label' => 'Walk tokens with a stack of names', 'next' => 'stk'],
            ],
        ],
        'wrong_dots' => [
            'message' => "You are wrong here.\nOnly the token \"..\" pops. The token \"...\" is pushed. Example 5 keeps /.../ as a folder.\nStep back to when you treated all dots as parent.",
            'outcome' => 'wrong',
            'rewind_to' => 'regex',
            'choices' => [],
        ],
        'stk' => [
            'message' => "Why skip empty tokens from split, and why refuse to pop an empty stack?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Empty tokens are extra slashes; popping past root would leave the path with no leading /', 'next' => 'join'],
                ['label' => 'Empty tokens are folder names; always pop on .. even at root', 'next' => 'wrong_root'],
            ],
        ],
        'wrong_root' => [
            'message' => "You are wrong. \"/../\" stays \"/\". The writeup pops only if the stack is nonempty.\nStep back to when you popped past root.",
            'outcome' => 'wrong',
            'rewind_to' => 'stk',
            'choices' => [],
        ],
        'join' => [
            'message' => "Join the stack with / and prefix one /. Root is just \"/\". Time O(n). Not Valid Parentheses.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The canonical path string from the name stack', 'next' => 'success'],
                ['label' => 'true/false like Valid Parentheses; this is a matching problem', 'next' => 'wrong_paren'],
            ],
        ],
        'wrong_paren' => [
            'message' => "You are wrong. Valid Parentheses matches (), [], {}. This problem returns a simplified path string.\nStep back to when you chose the return type.",
            'outcome' => 'wrong',
            'rewind_to' => 'join',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Split on /. Skip empty and \".\". Pop on \"..\" if the stack is nonempty. Push other tokens (including \"...\"). Return \"/\" plus the joined names. Time O(n). Path stack — not regex-only slash collapse, and not Valid Parentheses.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
