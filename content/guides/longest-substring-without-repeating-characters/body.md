Find the length of the longest **substring** (contiguous) with all unique characters. `"pwke"` is a subsequence of `"pwwkew"` and does not count; `"wke"` does.

A nested scan of every `[i, j]` pair is O(n²) and too slow for n up to 10⁵.

## Sliding window

Hold a window `[l, r]` that is always duplicate-free. Walk `r` through the string. Count how often each character appears in the window (`Counter` or a 128-slot array for ASCII).

When you add `s[r]` and its count becomes 2, advance `l`, decrementing counts, until that character’s count is 1 again. Then `r - l + 1` is the current unique length; keep the max.

Each index enters and leaves the window at most once, so the inner `while` is amortized O(1) per step.

**Time:** O(n)  
**Space:** O(|Σ|) — 128 for ASCII, or the distinct characters you actually see.

## `"abcabcbb"`

- `abc` — width 3, no repeats
- next `a` duplicates; slide `l` past the first `a` → `bca`, still 3
- later `bb` collapses to width 1
- Answer 3 (`"abc"`, `"bca"`, or `"cab"`)

On `"pwwkew"`, the second `w` forces `l` forward; the window that wins is `"wke"`.

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
