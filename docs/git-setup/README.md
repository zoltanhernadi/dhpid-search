# Git setup on Windows HC Laptop/Host Machine

Use PowerShell with Git for Windows and Git Credential Manager installed through
Company Portal. Enterprise and personal GitHub accounts authenticate separately
because they use different hosts.

## Set your variables

Replace the uppercase placeholder values below, then run this block once in
PowerShell. Run the remaining commands in the same PowerShell session so they
can reuse these variables. These are account names, not passwords or tokens.

```powershell
$EnterpriseUsername = "YOUR_ENTERPRISE_USERNAME"
$PersonalUsername = "YOUR_PERSONAL_USERNAME"
$RepoName = "REPO_NAME"
$BranchName = "YOUR_BRANCH_NAME"
```

This guide assumes the enterprise and personal repositories use the same
repository name.

## 1. Check Git and authentication support

```powershell
git --version
git credential-manager --version
git config --show-origin --get-all credential.helper
```

These instructions assume Git Credential Manager is the configured helper,
typically shown as `manager`. If it is missing or another helper is configured,
resolve that setup before continuing. No output from the last command means no
helper was found in the applicable configuration.

## 2. Authenticate both accounts

```powershell
git credential-manager github login --url https://github.hc-sc.gc.ca --username $EnterpriseUsername
git credential-manager github login --url https://github.com --username $PersonalUsername
```

Complete each sign-in prompt with the corresponding account. Existing credentials
may be reused; add `--force` to a login command if fresh authentication is needed.
Enter passwords or tokens only through Credential Manager's prompts, never in
repository files or command arguments.

Credentials are normally saved in Windows Credential Manager. The Git settings
`user.name` and `user.email` control commit authorship, not authentication.

## 3. Clone the enterprise repository

If you already have the clone, enter its directory and skip the clone command.
Do not delete an existing directory to repeat setup.

```powershell
git clone "https://github.hc-sc.gc.ca/hs/${RepoName}.git"
Set-Location -LiteralPath ".\$RepoName"
```

Inspect the existing state before creating branches or remotes:

```powershell
git status
git remote -v
git fetch origin
git branch -a
```

Commit or stash local changes before switching branches. Confirm `origin` points
to the intended enterprise repository.

## 4. Set up development

Create the local branch tracking the existing `origin/development` branch:

```powershell
git switch -c development --track origin/development
```

## 5. Add the approved personal repository

Create an empty, private repository on GitHub. Do not initialize it with a README,
license, or `.gitignore`.

```powershell
git remote add personal "https://github.com/${PersonalUsername}/${RepoName}.git"
git fetch personal
```

Fetch downloads
remote history and updates references such as `personal/main`; it does not merge,
switch branches, change working files, or upload code.

## 6. Create the personal local branch and push

```powershell
git switch -c $BranchName development
git push -u personal "${BranchName}:refs/heads/main"
```

This creates the local branch named by `$BranchName` from `development`, creates
or updates `main` in the personal repository, and sets the local branch to track
`personal/main`. It does not push the branch to the enterprise repository.

If that local branch already exists, inspect it and use `git switch $BranchName`
instead of creating it again. If the remote already contains history, reconcile
it before pushing. Do not force-push to bypass a rejection.

## 7. Verify configuration

```powershell
git remote -v
git branch -vv
git status
```

Expected tracking:

```text
development      -> origin/development
<your branch>    -> personal/main
```

With Git's usual `push.default=simple`, plain `git push` can fail because the local
branch named by `$BranchName` and upstream branch `main` have different names.
Use the explicit mapping for subsequent personal pushes:

```powershell
git push personal "${BranchName}:refs/heads/main"
```

This workflow does not automatically synchronize the personal and development
branches.

### Short sequence when already on development

After setting the variables and authenticating, with a clean working tree, no
existing local branch named by `$BranchName`, and a new empty approved personal
repository:

```powershell
git remote add personal "https://github.com/${PersonalUsername}/${RepoName}.git"
git fetch personal
git switch -c $BranchName development
git push -u personal "${BranchName}:refs/heads/main"
git branch -vv
git status
```

Skip `remote add` if the matching remote already exists. These raw commands are
not an idempotent setup script; inspect existing branches and remotes before
repeating them.

## 8. Sync changes between enterprise and personal

Run these commands from the repository directory, with `$BranchName` set as
above. Start with `git status` and commit or stash any uncommitted changes.
Run commands one at a time; stop if any command fails or reports conflicts.
These steps merge history without rebasing or force-pushing.

### Enterprise development to personal main

First pull enterprise changes into local `development`, then pull personal
`main` into your personal local branch before merging local `development`:

```powershell
git status
git switch development
git pull --ff-only origin development
git switch $BranchName
git pull --no-rebase personal main
git merge development
```

Review and test the merged changes before publishing:

```powershell
git push personal "${BranchName}:refs/heads/main"
```

This updates local `development` without modifying enterprise `development`.
The personal pull includes changes made on another machine or on GitHub.
`--no-rebase` merges those changes without rewriting local commits.
The final merge includes all commits on local `development`, including any
local commits not yet published to enterprise. Review them before pushing to
personal `main`.

### Personal main to enterprise development

Pull personal `main` into your personal local branch, then pull enterprise
changes into local `development` and merge your personal local branch:

```powershell
git status
git switch $BranchName
git pull --no-rebase personal main
git switch development
git pull --ff-only origin development
git merge $BranchName
```

This includes any local commits on `$BranchName`, not just commits already
published to personal `main`. Merge only if all incoming changes belong in
enterprise `development`.

Review and test the result, then publish if direct pushes are permitted:

```powershell
git push origin
```

If enterprise `development` requires a pull request, do not bypass that policy.
Instead of the direct push, publish the reviewed result to a new enterprise
review branch and open a pull request targeting `development`:

```powershell
$ReviewBranch = "YOUR_ENTERPRISE_REVIEW_BRANCH"
git push origin "development:refs/heads/${ReviewBranch}"
```

Use a new review branch name to avoid updating someone else's branch.
These pushes intentionally omit `-u`, preserving the existing upstream settings.
Only publish code and history permitted on the destination.

### Conflicts and rejected updates

If a merge reports conflicts, resolve the affected files, stage only those
files with `git add`, and complete the merge:

```powershell
git merge --continue
```

To cancel an in-progress merge:

```powershell
git merge --abort
```

If `--ff-only` fails, local and remote `development` have diverged. Stop and
review their histories before reconciling them; do not reset or force-push.
If a push is rejected because the remote advanced, fetch again, merge the
updated destination branch, and retest before retrying. Permission or branch
protection rejections require the appropriate access or pull-request workflow.
