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
            'message' => "Problem: input (length up to 1e4) is a valid file tree. Lines split by newline; depth is leading tabs. Return the length of the longest absolute file path, or 0 if there is no file. dir / subdir2 / file.ext is 20. The longer sample is 32. A lone a is a directory, so 0.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Split on spaces, or treat every name (including directories) as a file path', 'next' => 'wrong_split'],
                ['label' => 'Walk lines with a stack of directory prefix lengths; only names with a dot update the answer', 'next' => 'stk'],
            ],
        ],
        'wrong_split' => [
            'message' => "You are wrong here. The tree is encoded with newline and tab, not spaces. A directory has no dot; counting it as a path would make a return 1 instead of 0.\nStep back to when you split on spaces or scored directories.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'stk' => [
            'message' => "For each line, ident = leading tabs. Pop while the stack is deeper than ident so the top is the parent. Name length plus parent length plus 1 (the slash) is the absolute length. Files (a dot in the name) update the max. Directories push that length. Do not push files.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Forget the slash between components, or keep a sibling directory on the stack', 'next' => 'wrong_slash'],
                ['label' => 'Add one for the slash. Pop siblings first so the top is the parent', 'next' => 'kind'],
            ],
        ],
        'wrong_slash' => [
            'message' => "You are wrong. dir/subdir2/file.ext needs the slashes in the length (20). A same-depth neighbor must pop the previous sibling or the parent is wrong.\nStep back to when you skipped the slash or skipped the pop.",
            'outcome' => 'wrong',
            'rewind_to' => 'stk',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Simplify Path (71) normalizes . and .. tokens. Here tabs already encode the tree. The path has no trailing slash.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Stack of prefix lengths. dir/subdir2/file.ext → 20. a → 0. Not 71', 'next' => 'success'],
                ['label' => 'Run 71 on each line, or return a directory length when there is no file', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. 71 is a different string (cwd tokens). No file means 0, even if directories exist.\nStep back to when you used 71 or scored a directory.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Indent stack of prefix lengths. Files (dot in the name) update the max. dir/subdir2/file.ext → 20. a → 0. Not 71.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
