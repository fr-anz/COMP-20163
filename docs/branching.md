# Branching and pull requests

## Branch roles

| Branch | Purpose |
| --- | --- |
| `main` | Stable, reviewed versions suitable for demonstrating the project. Remains the GitHub default branch. |
| `staging` | Shared integration branch for combining and checking completed work before promoting a version to `main`. |
| Short-lived feature branches | One focused issue or change, created from the latest `staging` and merged back through a pull request. |

The normal flow is feature branch → `staging` → `main`. MVP v1 is the first working release; use the same flow for subsequent improvements toward the graded submission.

`staging` starts from the reviewed documentation commit on `main`. Both branches initially contain the same files and history. A branch does not create a hosted staging environment; deployment is separate work.

## First checkout

After cloning, fetch and create a local tracking branch for the existing remote `staging` branch:

```sh
git fetch origin
git switch --track origin/staging
```

Run this once. If the local branch already exists, use `git switch staging` instead.

## Start an issue

Begin with a clean working tree, update `staging`, and branch from it:

```sh
git switch staging
git pull --ff-only origin staging
git switch -c feat/3-listing-management
```

Use lowercase branch names with hyphens. Include the GitHub issue number when applicable:

- `feat/3-listing-management`: a new feature.
- `fix/6-duplicate-checkout`: a bug fix.
- `docs/branching-guide`: documentation.
- `chore/dependency-update`: maintenance.

Keep each branch focused on one reviewable change. Avoid using the shared branches for day-to-day edits, force-pushing them, or deleting `staging` after a release.

## Commit and open a pull request

Use Conventional Commit messages with a short, specific subject, for example:

- `feat: add listing management endpoints`
- `fix: prevent duplicate garment orders`
- `docs: clarify MVP inventory scope`
- `ci: update application checks`
- `build: update Vue dependencies`

Stage the intended files explicitly, commit, and push your feature branch:

```sh
git add backend/routes/api.php
git commit -m "feat: add listing management endpoints"
git push -u origin feat/3-listing-management
```

The paths and feature name above are examples; stage the actual files for your change.

On GitHub, open a pull request with `staging` as the base and your feature branch as the compare branch. Summarize the resulting behavior and validation, reference the relevant issue (for example, `Refs #3`), and request a teammate's review. Verify the issue's acceptance checklist before considering the work complete.

The team convention is at least one approving review and passing CI before merging. Prefer squash merging feature pull requests into `staging`, with a Conventional Commit title, then delete the short-lived branch once it is no longer needed.

## Promote a version

When the combined work on `staging` is ready:

1. Verify the shopping flow and applicable MVP acceptance criteria, including any changes integrated since the individual feature reviews.
2. Open a pull request with `main` as the base and `staging` as the compare branch. Describe the version's included work and validation.
3. Obtain a teammate's review and passing CI, then use **Create a merge commit** to merge the promotion. Preserving shared ancestry helps recurring promotions between the two long-lived branches.
4. Keep `staging` for the next iteration. Close completed issues after their acceptance criteria are verified; GitHub's issue-closing behavior should not replace that check.

If an urgent fix is merged into `main` separately, merge `main` back into `staging` through a pull request so later work includes it.

## CI and protection

The current CI workflow runs on pushes and pull requests for all branches, including `staging` and `main`. It checks Markdown, builds the Docker development image, builds/type-checks Vue, and validates/tests Laravel. Branch creation requires no additional CI trigger changes.

The review/merge rules above are team conventions. Creating `staging` does not configure GitHub enforcement. Repository administrators can separately protect both long-lived branches with required pull requests, one approving review, required CI checks, and restrictions on force pushes/deletion; see [GitHub's branch protection guide](https://docs.github.com/en/repositories/configuring-branches-and-merges-in-your-repository/managing-protected-branches/managing-a-branch-protection-rule).
