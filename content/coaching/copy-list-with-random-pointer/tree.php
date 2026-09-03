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
            'message' => "Problem: deep-copy a list where each node has next and random (random may be null). New nodes must not point at originals. [[7,null],[13,0],[11,4],[10,2],[1,0]] clones the same shape. Empty head → None.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Copy only next, leave random on the originals, Clone Graph’s neighbor DFS, or XOR like Single Number', 'next' => 'shallow'],
                ['label' => 'Hash map original→clone: first pass copies next, second pass sets d[cur].random from d[cur.random]', 'next' => 'map'],
            ],
        ],
        'shallow' => [
            'message' => "If random still points at old nodes, it is not a deep copy. Clone Graph walks an undirected neighbor list. XOR is unrelated.\nWhat is the missing idea?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'One pass that sets next and random before every clone exists, or return dummy instead of dummy.next', 'next' => 'wrong_other'],
                ['label' => 'Store every original→new pair while building next, then random can look up clones', 'next' => 'map'],
            ],
        ],
        'wrong_other' => [
            'message' => "You are wrong here.\nRandom can skip ahead; the target clone may not exist yet. dummy is a sentinel — return dummy.next.\nStep back to when you wired too early.",
            'outcome' => 'wrong',
            'rewind_to' => 'shallow',
            'choices' => [],
        ],
        'map' => [
            'message' => "d[cur] = new Node(cur.val), stitch tail.next. Then d[cur].random = d[cur.random] if cur.random else None. Time O(n), extra O(n).\nWhy two passes?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Random can point anywhere, including backward, so every clone must exist before you wire random', 'next' => 'ret'],
                ['label' => 'The second pass is only to copy val again, because the first pass forgot values', 'next' => 'wrong_val'],
            ],
        ],
        'wrong_val' => [
            'message' => "You are wrong. Values are copied in the first pass. The second pass is only random (and None stays None).\nStep back to when you recopied val.",
            'outcome' => 'wrong',
            'rewind_to' => 'map',
            'choices' => [],
        ],
        'ret' => [
            'message' => "Return dummy.next (the cloned head). None in, None out. Interleaving orig-copy-orig (O(1) extra) also works, but the hash map is the writeup’s first solution.\nWhat do you return?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'The cloned head, whose next and random point only at other clones', 'next' => 'success'],
                ['label' => 'The original head, because the values already match', 'next' => 'wrong_same'],
            ],
        ],
        'wrong_same' => [
            'message' => "You are wrong. Matching values is not a deep copy. Judges check node identity.\nStep back to when you returned the input.",
            'outcome' => 'wrong',
            'rewind_to' => 'ret',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Map old→new, copy next, then wire random via the map. Time O(n), extra O(n). Not a shallow random, not Clone Graph DFS, not XOR, not returning dummy or the original head.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
