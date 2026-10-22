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

## Short sequence when already on development

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
