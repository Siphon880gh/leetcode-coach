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
            'message' => "Problem: MovingAverage(size), then next(val) is the mean of the last min(count, size) stream values. Size 3: 1 → 1.0, then 10 → 5.5, then 3 → about 4.66667, then 5 → 6.0. At most 1e4 calls.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Re-sum the whole window each next, or treat this as Sliding Window Maximum (239) or Median (295 / 480)', 'next' => 'wrong_scan'],
                ['label' => 'Running sum plus a queue (or circular buffer) of length at most size', 'next' => 'sum'],
            ],
        ],
        'wrong_scan' => [
            'message' => "You are wrong here. Re-summing is extra work. 239 tracks a max, 295/480 track a median — this is a mean of a fixed window.\nStep back to when you rescanned, took a max, or took a median.",
            'outcome' => 'wrong',
            'rewind_to' => 'start',
            'choices' => [],
        ],
        'sum' => [
            'message' => "Keep s = sum of values currently in the window. If the queue is already full, subtract the front and pop it. Push val and add it to s. Return s / queue length (the window starts short).\nWhich trap?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Always divide by size, even before size values have arrived', 'next' => 'wrong_div'],
                ['label' => 'Divide by the current count. Circular: i = cnt mod size; s += val minus the old slot', 'next' => 'cpx'],
            ],
        ],
        'wrong_div' => [
            'message' => "You are wrong. First next on size 3 must be 1 / 1 = 1.0, not 1 / 3. Use min(count, size).\nStep back to when you always divided by size.",
            'outcome' => 'wrong',
            'rewind_to' => 'sum',
            'choices' => [],
        ],
        'cpx' => [
            'message' => "Circular array of length size: i = cnt mod size. s += val minus data[i] (old occupant is 0 until that slot has wrapped). Store val, bump cnt, return s / min(cnt, size). Time O(1) per next. Space O(size).\nLock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Running sum, drop the outgoing slot. Not 239, not 295. Divide by current count', 'next' => 'success'],
                ['label' => 'Store every stream value forever and average the last size from the full history', 'next' => 'wrong_hist'],
            ],
        ],
        'wrong_hist' => [
            'message' => "You are wrong. You only need the last size values. Extra history wastes space and still needs a running sum or a rescan.\nStep back to when you kept the entire stream.",
            'outcome' => 'wrong',
            'rewind_to' => 'cpx',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Running sum of a window of length at most size. Drop the outgoing slot when full. Divide by current count. O(1) per next. Not a max window, not a median stream.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
