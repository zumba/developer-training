# Git Branching & Rebasing

![git rebase example](rebase-on-master.gif)

> "Whoah, I’ve just read this quick tutorial about git and oh my god it is so cool. I am now super comfortable using it, and I’m not afraid **at all** of breaking anything." &mdash; said no one ever.
> 
> (paraphrased from Pierre de Wulf)

## Why you sometimes need to rebase
The best way to understand what happens when you rebase a branch&mdash;and how to handle conflicts&mdash;starts with understanding *why* you need to rebase a branch.

### Example
Let's say you need to commit some code to `zumba/public`. You first ensure that your local repository is up to date with the remote `master` branch.  Then you create a new feature branch:

```
(master)$ git pull origin master
```

> ```
> From github.com:zumba/public
>  * branch            master    -> FETCH_HEAD
> Already up-to-date.
> ```

```
(master)$ git checkout -b REQ-99999-feature
```

> ```
> Switched to a new branch 'REQ-99999-feature'
> ```

```
(REQ-99999-feature)$
```

#### Base commit
Your new branch `REQ-99999-feature` has a history that is exactly the same as the `master` branch.  It is useful to think of this point in the commit history as the "base" commit in the branch.  Any new commits to `master` do not show up in `REQ-99999-feature` &mdash;and vice-versa&mdash;yet both of them can trace their history back to this "base" commit.

As you make changes and commit them to `REQ-99999-feature`:

* All new commits in `REQ-99999-feature` do not exist in `master`.
* All new commits in `master` do not exist in `REQ-99999-feature`.
* Everything before and up to the "base" commit (`80770ca`) are the same in both branches.

#### Pull Request
After you finish working in your branch, you push the code up to github:

```
(REQ-99999-feature)$ git push origin REQ-99999-feature
```

> ```
> To git@github.com:zumba/public.git
>  * [new branch]      REQ-99999-feature -> REQ-99999-feature
> ```

You create a new pull request from `REQ-99999-feature` to the `master` branch on github.com, and then...

#### Conflicts

When you make a pull request on github, they check to see if git can merge the pull request without any conflicts.  Usually this works out fine, but sometimes:

![Cannot merge pull request](merge-conflict.png)

So what happened there?

Pull request merge conflicts are preventing github from handling the merge for you automatically.  This is almost *always* due to someone changing a file in the same place.  Someone created a branch from `master`&mdash;just like you did&mdash;and modified the same line of code as one of your commits; their pull request was merged into `master` some time *after* you created your branch (i.e. after your "base" commit).

To solve this problem you need to somehow get the other person's changes into your branch and resolve the conflict.  One way to do that is to `merge` the feature branch into `master` manually, but here at Zumba we prefer to `rebase` the feature branch; this results in a much cleaner commit history.

#### Rebase

To understand a rebase, think about it like this:

1. `git` first removes all of your changes from the feature branch; it rewinds the branch back to the "base" commit, and saves your rewound commits on the side somewhere.  Your feature branch and the `master` branch are now the same, except that any new commits that happened in `master` after the "base" commit (i.e. after you created your branch) are not in your branch.
2. `git` then grabs all of the new commits that were merged into `master` after your "base" commit and pulls them into your branch.  At this point your feature branch is exactly the same as the `master` branch *including* any new commits that happened in `master` after the "base" commit.  Forget about that old "base" commit.  Your new "base" is the most recent commit from `master`.  Hence, you have **re**-based your branch.
3. Now, `git` retrieves all of your commits that it set aside earlier and starts to "replay" them, one-by-one, on top of this new "base" commit.  This is essentially like creating your branch from scratch at this new point in time and then making your changes, it's just automated for you by `git`.
4. Eventually, as `git` is applying your new changes to the branch, it will encounter the conflict that started you down this path.

Our process of rebasing a feature branch looks like this:

```
(REQ-99999-feature)$ git checkout master
(master)$ git pull origin master
(master)$ git checkout REQ-99999-feature
(REQ-99999-feature)$ git rebase master
```

There are many ways to rebase a branch, but the four commands above will let you do it the right way every time.  Memorize those four commands.

![Relevant xkcd](git_2x.png)

#### Understanding the conflict

Changes in `git` are represented as a "diff" of lines.  Lines are never really *changed* in git; lines are removed and lines are added.  For example, say you have the following line of code:

```js
var bestServedCold = ['ice-cream', 'gazpacho'];
```

And you want to change it by adding another item to the array:

```js
var bestServedCold = ['ice-cream', 'gazpacho', 'revenge'];
```

When you commit that change, git actually records it like this:

```
- var bestServedCold = ['ice-cream', 'gazpacho'];
+ var bestServedCold = ['ice-cream', 'gazpacho', 'revenge'];
```

So, git recorded that you deleted a line and added a new line in the same place that the old one existed.  It doesn't have any context about what the lines of code actually do.  It only records what it used to look like, and what it looks like now.

A conflict happens when `git` tries to replay your "diff"&mdash;remove a line, add a line&mdash;but the line it is trying to remove looks different in your "diff" than the line in the actual file.  In the previous example, it tries to remove a line that looks like:

```js
var bestServedCold = ['ice-cream', 'gazpacho'];
```

But, due to someone else's changes introduced by the rebase, it finds that the file actually looks like this:

```js
var bestServedCold = ['ice-cream', 'gazpacho', 'steak-tartare'];
```

So, your "diff" doesn't make any sense to `git`.  It would be dangerous for `git` to ignore that your "diff" is trying to remove a line that looks totally different, so `git` pauses the "replay" and adds a bunch of annotations to the file that explain the problem:

```js
<<<<<<< HEAD
var bestServedCold = ['ice-cream', 'gazpacho', 'steak-tartare'];
=======
var bestServedCold = ['ice-cream', 'gazpacho', 'revenge'];
>>>>>>> Adding revenge to the dishes best served cold
```

This can look cryptic at first, but it's easy to understand.

* The entire conflict exists between `<<<<<<<` and `>>>>>>>`.  There could be multiple lines, but in this example there is only one.
* There are two sections divided by `=======`.
* The top section, labeled `HEAD`, shows you what the lines look like before trying to add your changes.
* The bottom section shows your changes, and you see your commit message there.

So, how do you resolve the conflict? [help.github.com](https://help.github.com/articles/resolving-a-merge-conflict-from-the-command-line/) explains it best:

> You have several options here. You can either keep your changes, take your friend's changes, or make a brand new change. Whatever you do, you need to make sure to resolve the conflict such that the file makes sense, and everyone is happy.

So, you delete all of the annotations git added and change the file to look like this:

```js
var bestServedCold = ['ice-cream', 'gazpacho', 'steak-tartare', 'revenge'];
```

Now, you need to tell git that *this* is the way it should "replay" the commit that was failing.  To do that you add the file, and then tell `git` to continue the rebase:

```
(REQ-99999-feature)$ git add path/to/theFileYouFixed.js
(REQ-99999-feature)$ git rebase --continue
```

At this point, git will use your new, resolved changes in place of the old, conflicting changes and move on.  It's as if you made the change to include `'revenge'` after `'steak-tartare'` all along.  `git` will then go to your next commit and continue replaying your stuff until a new conflict happens, or all of your changes are replayed.

#### Force Push
Now for something a little precarious.

Once all of your changes are finished replaying and all conflicts are resolved you need to push the rebased branch up to github:

```
(REQ-99999-feature)$ git push origin REQ-99999-feature
```

> ```
> ! [rejected]        REQ-99999-feature -> REQ-99999-feature (non-fast-forward)
> hint: Updates were rejected because the tip of your current branch is behind
> hint: its remote counterpart. Integrate the remote changes (e.g.
> hint: 'git pull ...') before pushing again.
> hint: See the 'Note about fast-forwards' in 'git push --help' for details.
> ```

So what happened now?  Github rejected your push.  The reason this happened is because you've "re-written history" in your branch, and the version on github is now much different than the version you are trying to push.  Github thinks you've done something wrong, and is protecting you from making a mistake.

However, you know that you just deliberately rebased your branch, and you do want the branch in Github to be replaced with your new version.  To do that, you need to "force" the push.

```
(REQ-99999-feature)$ git push origin REQ-99999-feature --force
```

This will be successful, and your pull request should now be ready to merge.

***NOTE:*** This is the **only valid reason for you to force a push to github**.  Make sure you specify `origin your-branch-name` when you force push.  If you accidentally force push the wrong branch, you could be destroying work history of yourself or someone else on the team.  If you find yourself thinking that you need to force push for any other reason than rebasing a feature branch, check with your lead developer for help.
