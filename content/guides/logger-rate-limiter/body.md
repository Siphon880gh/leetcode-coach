Stream of `(timestamp, message)` in non-decreasing time. Print a unique message at most once every 10 seconds: if it printed at `t`, the next identical print is allowed at `t + 10`. Several messages may share a timestamp. Example: `foo` at 1 (true), `bar` at 2 (true), `foo` at 3/10 (false), `foo` at 11 (true). At most 10^4 calls.

## Map message → next allowed time

Store `ts[message] = next allowed timestamp` (missing key means 0). On `shouldPrintMessage(timestamp, message)`: if `timestamp < ts[message]`, return false. Else set `ts[message] = timestamp + 10` and return true.

Different messages do not share a cooldown. Do not use a single last-print clock. Do not treat `t + 10` as still blocked (`>=` is allowed). Timestamps already arrive in order, so you do not need a queue of the last 10 seconds unless you want to evict old keys.

Time: O(1) per call  
Space: O(distinct messages)

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
