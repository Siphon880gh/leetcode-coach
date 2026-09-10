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
            'message' => "Problem: integers a and b in −1000 .. 1000. Return a plus b without using the plus or minus operators. 1, 2 → 3. 2, 3 → 5.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call plus, minus, or a language sum helper anyway', 'next' => 'wrong_plus'],
                ['label' => 'XOR for the bit sum, (a AND b) shifted left 1 for the carry, loop until carry is 0', 'next' => 'xor'],
            ],
        ],
        'wrong_plus' => [
            'message' => "You are wrong here. The judge forbids plus and minus, including hiding them inside sum().\nStep back to when you used an add operator.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'xor' => [
            'message' => "XOR is addition when no two 1s share a column. Both 1s in a column make a carry into the next bit: (a AND b) shifted left 1. Set a to the XOR, b to the carry, repeat until b is 0. Then a is the sum. 1 xor 2 is 3 with carry 0.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Shift the carry right, or treat this as Add Two Numbers (2) on digit lists', 'next' => 'wrong_shift'],
                ['label' => 'Carry always moves one bit toward the high end; this is a machine word, not a list', 'next' => 'kind'],
            ],
        ],
        'wrong_shift' => [
            'message' => "You are wrong. A carry goes into the next higher column, so you shift left. Problem 2 walks reversed decimal lists.\nStep back to when you shifted the wrong way or treated this as 2.",
            'outcome' => 'wrong',
            'rewind_to' => 'xor',
            'choices' => [],
        ],
        'kind' => [
            'message' => "Java and C++ 32-bit ints already wrap like two’s complement. Python ints grow without bound: mask both values to 32 bits each step (AND 0xFFFFFFFF). If the sign bit is set, convert back with ~(a xor 0xFFFFFFFF).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'XOR plus left-shifted carry, 32-bit mask in Python. Not plus. Not 2', 'next' => 'success'],
                ['label' => 'Skip the mask in Python; unbounded ints already match Java wrap', 'next' => 'wrong_py'],
            ],
        ],
        'wrong_py' => [
            'message' => "You are wrong. Python will keep extra high bits, so negatives never look like 32-bit two’s complement.\nStep back to when you skipped the 32-bit mask.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. XOR the bits, left-shift the AND carry, loop until carry is 0. Mask in Python. 1, 2 → 3. Not plus. Not 2.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
