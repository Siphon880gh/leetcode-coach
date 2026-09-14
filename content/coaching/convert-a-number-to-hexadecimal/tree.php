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
            'message' => "Problem: 32-bit signed int num in −2^31 .. 2^31−1. Return its lowercase hex string. Negatives use two’s complement, not a minus sign. No leading zeros except the number 0. Built-in hex formatters are banned. 26 → 1a. −1 → ffffffff.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call hex() / format / toString(16), or emit a minus sign for negatives', 'next' => 'wrong_builtin'],
                ['label' => 'Treat bits as two’s complement. Peel eight 4-bit groups from high to low', 'next' => 'nibbles'],
            ],
        ],
        'wrong_builtin' => [
            'message' => "You are wrong here. The problem forbids a library that prints hex. A leading minus is not two’s complement: −1 must be eight f’s, not \"-1\".\nStep back to when you used a formatter or a minus sign.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'nibbles' => [
            'message' => "If num is 0, return \"0\". Else loop i from 7 down to 0. x = (num shifted right by 4 times i) bitwise-and 15. Map x through 0123456789abcdef. Skip x==0 while the answer is still empty so leading zeros drop. Python’s >> on a negative int still exposes the low 32 bits you need for this walk.\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Keep all eight digits always, or stop after the first nibble so 26 becomes only a', 'next' => 'wrong_zeros'],
                ['label' => 'Skip leading zeros, but keep later zeros. Special-case 0 so you do not return empty', 'next' => 'kind'],
            ],
        ],
        'wrong_zeros' => [
            'message' => "You are wrong. Eight digits would print 0000001a for 26. Stopping after one nibble drops the 1. Only leading zeros vanish; zeros in the middle stay.\nStep back to when you kept every nibble or stopped too early.",
            'outcome' => 'wrong',
            'rewind_to' => 'nibbles',
            'choices' => [],
        ],
        'kind' => [
            'message' => "26 is 0001 1010 → 1a. −1 is 32 ones → ffffffff. Base 7 (504) is a different base with a sign. Integer to Roman (12) maps ranges, not 4-bit groups.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Eight nibbles, skip leading zeros, 0 → 0. 26 → 1a. −1 → ffffffff. Not hex()', 'next' => 'success'],
                ['label' => 'Uppercase A–F, or treat −1 as 32-bit unsigned wrap without walking eight groups', 'next' => 'wrong_kind'],
            ],
        ],
        'wrong_kind' => [
            'message' => "You are wrong. Letters must be lowercase. You still have to walk the eight groups (or unsigned-shift by 4 until the 32-bit word is 0) so −1 becomes eight f’s, not an empty string.\nStep back to when you used uppercase or skipped the eight-nibble walk.",
            'outcome' => 'wrong',
            'rewind_to' => 'kind',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Eight nibbles from high to low, skip leading zeros, map 0–15 to 0123456789abcdef. 0 → 0. Not hex(). Not a minus-sign string.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
