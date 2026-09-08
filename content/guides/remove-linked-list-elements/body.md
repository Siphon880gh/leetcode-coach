Given `head` and integer `val`, drop every node whose value equals `val` and return the new head. Up to 10⁴ nodes. `[1,2,6,3,4,5,6]`, `val = 6` → `[1,2,3,4,5]`. Empty list stays empty. `[7,7,7,7]`, `val = 7` → empty.

## Dummy predecessor; skip, do not step, when next matches

Remove Nth from End used a dummy so deleting the real head is the same splice. Sorted list 83 skips a duplicate next and stays. Here the match is a **given** `val`, not “equal to current,” and a run of matches can sit at the front.

`dummy.next = head`. `pre = dummy`. While `pre.next`: if `pre.next.val == val`, set `pre.next = pre.next.next` and **stay** on `pre` (two 6s in a row would otherwise keep the second). Else `pre = pre.next`. Return `dummy.next`. Walking from `head` without a dummy misses a matching first node unless you special-case a new head.

Do not free only the first match. Do not step `pre` after a skip. Recursion twin: if `head.val == val` return the rest of the recursive result; else attach that result to `head.next` and return `head`. Same one-pass idea, O(n) stack.

**Time:** O(n)  
**Space:** O(1) iterative, O(n) recursive stack

> [!ui-builder] Mini game
> INPUT_TOPIC: Theory or problem
> INPUT_SLUG: Folder slug (kebab-case)
> PROMPT:
> Use the harness skill at .agents/skills/harness to create a mini-game in this Algo Learning IDE app that teaches [INPUT_TOPIC]. Place it under content/games/[INPUT_SLUG]/. Follow meta.php + index.html. Use .agents/skills/game-development-sickn33 for web/2d craft if needed.

> [!ui-builder] Step-by-step
> INPUT_TOPIC: Theory or problem
> INPUT_SLUG: Folder slug (kebab-case)
> PROMPT:
> Use the harness skill at .agents/skills/harness to create a step-by-step session for [INPUT_TOPIC] under content/coaching/[INPUT_SLUG]/. Include branching choices with clear labels, at least one wrong-path leaf with rewind_to, and a success leaf. Follow the tree.php contract so Step back and the Path visualizer work.
