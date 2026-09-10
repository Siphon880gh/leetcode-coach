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
            'message' => "Problem: Trips (client_id, driver_id, status, request_at) and Users (users_id, banned). Cancellation rate per day 2013-10-01..03: cancelled trips / all trips that day, but only when both client and driver have banned = No. Round to two decimals. Sample: 0.33, 0.00, 0.50.\nWhat do you try first?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'GROUP BY request_at and COUNT cancelled over all trips — ignore banned', 'next' => 'noban'],
                ['label' => 'Inner-join Users twice: client and driver both banned = No, then group by day', 'next' => 'join'],
            ],
        ],
        'noban' => [
            'message' => "Ignoring banned is wrong. Sample day 1 has four trips but client 2 is banned, so that cancel is dropped. Rate is 1/3 = 0.33, not 2/4.\nWhat is the missing filter?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Join Users only on client_id; a banned driver still counts', 'next' => 'wrong_client'],
                ['label' => 'Join Users as u1 on client_id and u2 on driver_id, both banned = No', 'next' => 'join'],
            ],
        ],
        'wrong_client' => [
            'message' => "You are wrong here.\nBoth sides must be unbanned. Inner-joining only the client keeps trips with a banned driver.\nStep back to when you skipped the driver join.",
            'outcome' => 'wrong',
            'rewind_to' => 'noban',
            'choices' => [],
        ],
        'join' => [
            'message' => "WHERE request_at BETWEEN '2013-10-01' AND '2013-10-03'. GROUP BY request_at. Days with no remaining trips vanish (that is “at least one trip”).\nHow do you get the rate?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => "ROUND(AVG(status != 'completed'), 2) — 1 for either cancel status, 0 for completed", 'next' => 'rate'],
                ['label' => 'COUNT cancelled_by_client only; skip cancelled_by_driver', 'next' => 'wrong_drv'],
            ],
        ],
        'wrong_drv' => [
            'message' => "You are wrong. Driver cancels count too. status != completed covers both cancel enums.\nStep back to when you dropped driver cancels.",
            'outcome' => 'wrong',
            'rewind_to' => 'join',
            'choices' => [],
        ],
        'rate' => [
            'message' => "Alias Day and Cancellation Rate. Sample: 0.33, 0.00, 0.50. Customers Who Never Order is an anti-join; here you keep trips that match two unbanned users.\nReady to lock it in?",
            'outcome' => 'continue',
            'choices' => [
                ['label' => 'Two Users joins, date window, AVG of not-completed, ROUND two decimals', 'next' => 'success'],
                ['label' => 'COUNT(1) of cancel rows with no divide by the day’s total', 'next' => 'wrong_div'],
            ],
        ],
        'wrong_div' => [
            'message' => "You are wrong. The rate is cancelled / all unbanned trips that day, not a raw cancel count.\nStep back to when you skipped the denominator.",
            'outcome' => 'wrong',
            'rewind_to' => 'rate',
            'choices' => [],
        ],
        'success' => [
            'message' => "Correct. Join Users twice (client and driver unbanned). Date window. GROUP BY day. ROUND(AVG(status is not completed), 2). Do not ignore banned, skip the driver, or count cancels without dividing.\nYou finished this step-by-step path. Restart anytime, or step back to revisit a decision.",
            'outcome' => 'success',
            'choices' => [],
        ],
    ],
];
