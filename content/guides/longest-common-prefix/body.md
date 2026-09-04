Find the longest string that is a prefix of every entry in `strs`. If they share nothing, return `""`. `["flower","flow","flight"]` → `"fl"`. `["dog","racecar","car"]` → `""`.

At most 200 strings, each at most 200 lowercase letters (or empty).

## Vertical scan

Treat `strs[0]` as the candidate. For column `i` from `0` to `len(strs[0]) - 1`, check every other string: if `i` is past its end, or `s[i] != strs[0][i]`, return `strs[0][:i]`. If every column of `strs[0]` survives, the whole first string is the prefix.

A trie also works; vertical scan is enough at these sizes and uses no extra tree.

**Time:** O(n × m) — n strings, m = shortest length  
**Space:** O(1) besides the answer

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
