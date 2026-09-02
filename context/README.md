# Context libraries

Local clones of public GitHub repos that already contain LeetCode and LeetCode-type problems with solutions and explanations. This folder is reference material for Cursor when authoring guides, mini games, and step-by-step sessions. It is not a PHP app section.

Clones stay on disk only. They are gitignored and are not redistributed by this repo. Licenses and copyright remain with each upstream project.

## Clone

From the app repo root:

```bash
bash context/clone.sh
```

The script shallow-clones (`--depth 1`) into the folders below. If a folder is already a git clone, it runs `git pull --ff-only`.

## Catalog

| Folder | Upstream | Use for |
|--------|----------|---------|
| `neetcode-leetcode` | [neetcode-gh/leetcode](https://github.com/neetcode-gh/leetcode) | English interview solutions in several languages |
| `walkccc-leetcode` | [walkccc/LeetCode](https://github.com/walkccc/LeetCode) | Readable C++ / Java / Python / TypeScript / MySQL solutions |
| `doocs-leetcode` | [doocs/leetcode](https://github.com/doocs/leetcode) | Bilingual problem writeups and multi-language solutions (LeetCode, 剑指 Offer, Cracking the Coding Interview) |
| `hello-algo` | [krahets/hello-algo](https://github.com/krahets/hello-algo) | Data structures and algorithms with explanations (LeetCode-type, not numbered LeetCode dumps) |
| `labuladong-algorithm` | [labuladong/fucking-algorithm](https://github.com/labuladong/fucking-algorithm) | Pattern explanations (why, not only how). Folder name is sanitized; upstream repo name is unchanged |
| `leetcode-master` | [youngyangyang04/leetcode-master](https://github.com/youngyangyang04/leetcode-master) | Illustrated LeetCode writeups and ordered problem lists |

## Authoring

After cloning, open matching writeups under `context/` when creating Algo Guides, mini games, or step-by-step sessions via `.agents/skills/harness`.
