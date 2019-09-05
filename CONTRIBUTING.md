## Contribution Guide

We use github to track and host our projects through WPVIP. All our work gets done locally first, then pushed to the preprod branch for environment QA and for sending links for approval. Once the feature is complete and approved, a Pull Request is created on github towards the `develop` branch and assign the project lead for a code review and merge approval.
The workflow is broken down further blow:

- Set up local environment for WPVIP development
  - WPVIP's guide to setup local environment: https://wpvip.com/documentation/vip-go/local-vip-go-development-environment/
  - Our team' code standards. We believe that the codebase should really look like one person coded it all: https://github.com/NationalUniversitySystem/nusa-code-standards

- There are typical three main branches in our projects (develop, preprod, and master) representing each environment, master representing the live/production environment.
- Never do Pull Requests/merges to the master branch from a feature branch
- Do not commit the files in the assets folder. These will be built on merge for each environment branch.

- For a new features request, branch off of `develop`
- Test functionality locally
- Commit all work to feature branch
- Push branch once it works locally
- In github, do a pull request from feature branch to merge into `preprod` for QA/revision, or `develop` if it is ready for the live site
- Pull Request should include a description of what the merge will affect
- Assign the project lead as a reviewer
- Add labels if applicable
- Fix any review comments or automated checks that appear in the comments
- Await reviewers' approval for merge, check work on environment (preprod or develop)
- Await next code release. Once code is on the live site, check the pages/code affected and mark work for approval one final time in project management system

Branch naming convention includes folders to keep our branches as organized as possible:
- `plugins/{plugin-name-slug-folder}/{feature-or-fix-name}` for plugin development
- `themes/{feature-name-for-all-themes}` for developing a fix/feature that will apply to all the sites' themes
- `themes/{specific-theme-slug}/{feature-name}` for developing a feature which will specifically apply to one theme
