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
            'message' => "Problem: non-negative num to English words. 123 → One Hundred Twenty Three. 12345 → Twelve Thousand Three Hundred Forty Five. 0 → Zero.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Integer to Roman: map place values to I, V, X style symbols', 'next' => 'roman'],
                ['label' => 'Zero first; then billion / million / thousand / ones chunks of three digits', 'next' => 'chunks'],
            ],
        ],
        'roman' => [
            'message' => "Roman numerals are a different problem (12). Here you need spoken English and scale words (Thousand, Million).\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Print every digit with Zero padding: 100 → One Hundred Zero', 'next' => 'wrong_pad'],
                ['label' => 'Walk i = 1e9, then i /= 1000. Convert a nonzero 0–999 chunk plus its scale', 'next' => 'chunks'],
            ],
        ],
        'wrong_pad' => [
            'message' => "You are wrong here.\n100 is One Hundred. Zero is only the whole-number special case.\nStep back to when you padded empty places with Zero.",
            'outcome' => 'wrong',
            'rewind_to' => 'roman',
            'choices' => [],
        ],
        'chunks' => [
            'message' => "Helper transfer(x) for 0..999: empty if 0; under 20 lookup; under 100 tens plus transfer(mod 10); else hundreds digit, Hundred, transfer(mod 100). Forty not Fourty.\nWhich sample?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => '12345 → Twelve Thousand Three Hundred Forty Five. Skip a 0 group so Million does not appear', 'next' => 'cpx'],
                ['label' => '13 → Ten Three; skip the teens table', 'next' => 'wrong_teens'],
            ],
        ],
        'wrong_teens' => [
            'message' => "You are wrong. 13 is Thirteen. Values under 20 are a lookup, not Ten plus a ones digit.\nStep back to when you dropped the teens table.",
            'outcome' => 'wrong',
            'rewind_to' => 'chunks',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(1) time: at most four groups, each a constant helper. Space O(1) besides the output.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Zero; three-digit groups plus scale; helper with teens and Forty. Not Roman, not Zero padding', 'next' => 'success'],
                ['label' => 'Always print Billion Million Thousand even when those groups are 0', 'next' => 'wrong_scale'],
            ],
        ],
        'wrong_scale' => [
            'message' => "You are wrong. Skip a group whose quotient is 0 so you do not emit a stray Million.\nStep back to when you printed every scale word.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Zero is special. Split into three-digit groups with Billion / Million / Thousand. Helper: under 20, tens, then Hundred. Skip empty groups. Not Integer to Roman.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
