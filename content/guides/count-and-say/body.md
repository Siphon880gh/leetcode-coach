`countAndSay(1)` is `"1"`. Each later term is the run-length encoding of the previous term: for every maximal run of the same digit, append the run length (as a decimal) then that digit. Return the `n`th term. `1 ≤ n ≤ 30`.

`n = 4` → `"1211"` because `"1"` → `"11"` → `"21"` → `"1211"`.

## Run-length the previous term

Build iteratively. Hold the current string `s` (start `"1"`). Repeat `n - 1` times:

Walk `s` with two indices. At `i`, let `j` run forward while `s[j] == s[i]`. The run length is `j - i`. Append `str(j - i)` and `s[i]`. Set `i = j`.

That new string becomes `s`. After `n - 1` encodings you have the answer.

Do not invent a closed form. The sequence is defined only by this “say what you see” step. Recursing on `n` is the same work; a loop just keeps the last term.

**Time:** O(n × m) where `m` is the length of the longest intermediate string  
**Space:** O(m)

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
