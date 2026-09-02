#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")" && pwd)"

clone_repo() {
  local url="$1"
  local dest="$2"
  local path="$ROOT/$dest"

  if [[ -d "$path/.git" ]]; then
    echo "Updating $dest ..."
    git -C "$path" pull --ff-only
  elif [[ -d "$path" ]]; then
    echo "Skipping $dest: $path exists but is not a git clone"
  else
    echo "Cloning $dest ..."
    git clone --depth 1 "$url" "$path"
  fi
}

clone_repo https://github.com/neetcode-gh/leetcode.git neetcode-leetcode
clone_repo https://github.com/walkccc/LeetCode.git walkccc-leetcode
clone_repo https://github.com/doocs/leetcode.git doocs-leetcode
clone_repo https://github.com/krahets/hello-algo.git hello-algo
clone_repo https://github.com/labuladong/fucking-algorithm.git labuladong-algorithm
clone_repo https://github.com/youngyangyang04/leetcode-master.git leetcode-master

echo "Done. Catalog: $ROOT/README.md"
