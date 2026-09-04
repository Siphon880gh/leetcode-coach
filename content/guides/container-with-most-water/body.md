Vertical lines at `i` have height `height[i]`. Pick two indices so the rectangle with the x-axis holds the most water: area is `min(height[l], height[r]) * (r - l)`. You may not slant. n can be 10⁵, so O(n²) pairs are too slow.

`[1,8,6,2,5,4,8,3,7]` → 49 (the 8 at index 1 and the 7 at the end: min 7 × width 7).

## Two pointers

Start `l = 0`, `r = n - 1`. Record the area, then **move the shorter line** inward (if equal, either side). The width always shrinks by 1. The only way area can grow is a taller limiting wall.

Moving the taller line cannot help: the height is still capped by the short one, and width is smaller. So every discarded pointer is safe.

**Time:** O(n)  
**Space:** O(1)

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
