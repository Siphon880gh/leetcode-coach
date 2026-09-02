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
            'message' => "Problem: multiply two non-negative integers given as strings. Must not parse them as a machine int or use a BigInteger library. \"2\" × \"3\" → \"6\". \"123\" × \"456\" → \"56088\". Lengths ≤ 200.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'int(num1) * int(num2), then convert the product back to a string', 'next' => 'parse'],
                ['label' => 'Array of length m+n; add num1[i]*num2[j] into slot i+j+1; carry; strip a leading 0', 'next' => 'mul'],
            ],
        ],
        'parse' => [
            'message' => "Lengths up to 200 overflow 64-bit ints. The problem also bans converting the inputs to integers directly, including language bigints that wrap a library.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Python int is unbounded, so parsing is still allowed on this judge', 'next' => 'wrong_bigint'],
                ['label' => 'Simulate paper multiplication: each digit pair writes into a position array of size m+n', 'next' => 'mul'],
            ],
        ],
        'wrong_bigint' => [
            'message' => "You are wrong here.\nThe note is about the algorithm, not the language. You must multiply digit by digit.\nStep back to when you chose parsing.",
            'outcome' => 'wrong',
            'rewind_to' => 'parse',
            'choices' => [],
        ],
        'mul' => [
            'message' => "Why i+j+1, and why m+n slots rather than m+n-1?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Ones place of the product sits at index m+n-1; the high digit may need one extra slot (length m+n)', 'next' => 'example'],
                ['label' => 'Write into i+j only; m+n-1 is always enough because 99×99 is 4 digits', 'next' => 'wrong_idx'],
            ],
        ],
        'wrong_idx' => [
            'message' => "You are wrong. 99×99 = 9801 is 4 = 2+2 digits. The general max length is m+n, and the ones contribution of num1[i]*num2[j] lands at i+j+1 when the array is left-aligned.\nStep back to when you chose the layout.",
            'outcome' => 'wrong',
            'rewind_to' => 'mul',
            'choices' => [],
        ],
        'example' => [
            'message' => "If either string is \"0\", return \"0\" immediately (otherwise you might emit leading zeros only). After the nested add, carry from the right: arr[i-1] += arr[i]//10; arr[i] %= 10. Drop arr[0] if it is 0. \"123\"×\"456\" = \"56088\".\nWhat is the complexity?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'O(m · n) time and O(m + n) extra for the digit array', 'next' => 'success'],
                ['label' => 'O(m + n) because you only walk each input string once', 'next' => 'wrong_n'],
            ],
        ],
        'wrong_n' => [
            'message' => "You are wrong. Every digit of num1 is paired with every digit of num2. That nested loop is Θ(m · n).\nStep back to when you scored the pass.",
            'outcome' => 'wrong',
            'rewind_to' => 'example',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Early \"0\". arr size m+n. For each pair, arr[i+j+1] += a*b. Carry right-to-left. Skip a leading 0. Time O(m·n), space O(m+n). No parsing of the whole number.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
