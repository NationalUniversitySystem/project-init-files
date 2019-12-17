## Contribution Guide

We use Github to track and host our projects through WPVIP.

All our work gets done locally first, then pushed to the `preprod` branch for environment QA and for sending links for approval.

This also applies to content updates, please update on the QA/`preprod` site first and submit for approval the appropriate contacts.

Once the coding feature or change is complete and approved, create a Pull Request on Github towards the `develop` branch, then assign the project lead for a code review and merge approval.

The workflow is broken down further below.

### Workflow
- Set up local environment for WPVIP development
  - WPVIP's guide to setup local environment: https://wpvip.com/documentation/vip-go/local-vip-go-development-environment/
  - Our team's code standards. We believe that the codebase should really look like one person coded it all: https://github.com/NationalUniversitySystem/nusa-code-standards

- There are typical three main branches in our projects (`develop`, `preprod`, and `master`) representing each environment, `master` representing the live/production environment.
- Never do Pull Requests/merges to the `master` branch from a feature branch (only reverting code or emergency fixes)
- Do not commit the files in the assets folder. These will be built on merge for each environment branch.
---
- To start work on a new features request, branch off of `develop` ([naming convention below](#branch-naming-convention))
- Test functionality locally
- Commit all work to feature branch (commit early, commit often, do not push up to remote/origin)
- Push branch to remote/origin once it works locally
- In Github, do a pull request from feature branch to merge into `preprod` for QA/revision, or `develop` if it is ready for the live site
- Pull Request should include a description of what the merge will affect (repos should have templates for PRs)
- Assign the project lead as a reviewer
- Add labels if applicable (at least a priority label)
  - **Priority 3** - Low priority - Does not need to be released at the moment.
  - **Priority 2** - Mid-level priority - Should be released at earlies convenience.
  - **Priority 1** - High priority - Should be released ASAP (e.g. bug fixes)
- Fix any review comments or automated checks that appear in the comments
- Await reviewers' approval for merge
- Check work on environment (`preprod` or `develop`)
- Await next code release. Once code is on the live site, check the pages/code affected and mark work for approval one final time in project management system

Flowchart for visual aid:
![Coding Workflow](images/coding-workflow.jpg)

### Branch Naming Convention
Branch naming convention includes folders to keep our branches as organized as possible:
- `plugins/{plugin-name-slug-folder}/{feature-or-fix-name}` for plugin development
- `plugins/{plugin-name-slug-folder}` for 3rd party plugin updates
- `themes/{feature-name-for-all-themes}` for developing a fix/feature that will apply to all the sites' themes
- `themes/{specific-theme-slug}/{feature-name}` for developing a feature which will specifically apply to one theme
