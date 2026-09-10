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
            'message' => "Problem: wrap an iterator so peek returns the next value without advancing, while next and hasNext still work. [1,2,3]: next → 1, peek → 2, next → 2, next → 3, hasNext → false.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy nums into your own list and ignore the given Iterator', 'next' => 'wrong_copy'],
                ['label' => 'Cache one next: hasPeeked plus peekedElement', 'next' => 'cache'],
            ],
        ],
        'wrong_copy' => [
            'message' => "You are wrong here.\nThe constructor takes an Iterator, not a list you own. Wrap next/hasNext; do not dump the source.\nStep back to when you copied the array.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'cache' => [
            'message' => "peek: if not peeked, peekedElement = iterator.next() and hasPeeked = true; return the stash. next: if not peeked, iterator.next(); else clear the flag and return the old stash. hasNext: hasPeeked or iterator.hasNext().\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Call iterator.next on every peek (that skips values)', 'next' => 'wrong_skip'],
                ['label' => 'A leftover peek still counts in hasNext after the inner iterator is spent', 'next' => 'cpx'],
            ],
        ],
        'wrong_skip' => [
            'message' => "You are wrong. A second peek must return the same value. Pulling iterator.next again would skip.\nStep back to when you advanced on every peek.",
            'outcome' => 'wrong',
            'rewind_to' => 'cache',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "O(1) per call, O(1) extra. Follow-up: same flag and stash for any type, not only ints.\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'One cached element. Not copy-the-list, not peek-always-next, not hasNext = only inner.hasNext', 'next' => 'success'],
                ['label' => 'hasNext is only iterator.hasNext, even when a peek is pending', 'next' => 'wrong_has'],
            ],
        ],
        'wrong_has' => [
            'message' => "You are wrong. After peek consumes the last inner next, iterator.hasNext is false but you still hold the stash. hasNext must be hasPeeked or iterator.hasNext().\nStep back to when you ignored the stash.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. peek caches one iterator.next. next drains that stash or pulls fresh. hasNext sees the stash. Not a copied list, not double-advance on peek.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
