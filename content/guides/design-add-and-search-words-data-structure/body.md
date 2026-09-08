`WordDictionary`: `addWord(word)` stores lowercase words; `search(word)` is true if some stored word matches, where `.` matches any letter. At most two dots per search. At most `10⁴` mixed calls. After `addWord("bad")`, `"dad"`, `"mad"`: `search("pad")` false, `"bad"` true, `".ad"` true, `"b.."` true.

## Same trie as Implement Trie; branch on `.`

Implement Trie already walks 26 slots and sets `isEnd`. `addWord` is that same insert. The new work is `search`: a letter must take that child (missing child → false). A `.` tries **every non-null child** and succeeds if any suffix walk succeeds. After the last character, return that node’s `isEnd` — `".ad"` must be a full word, not a prefix of `"baddy"`.

At most two dots, so the 26-way branch stays cheap (`26²` times leftover letters). Do not scan a list of all inserted strings on every search. Do not treat `.` as a literal character in the trie. Do not skip `isEnd` and accept any path that exists.

**Time:** O(m) per `addWord`; search O(26^d · m) with d ≤ 2 dots  
**Space:** O(total characters inserted times 26)

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
