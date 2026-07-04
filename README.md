# github-user-activity-cli-tool
- Simple command line interface (CLI) to fetch the recent activity of a GitHub user and display it in the terminal.
- This project for [text](https://roadmap.sh/projects/github-user-activity)

## Prerequisites
1. Docker

## Installation
1. Clone project
2. `cd` into project
3. Run the following to create docker image `docker build -t github-activity-cli .`
4. create a container from this image
5. `bash` into the container and run `php src/github-activity.php <username>`, should see the activities


## Notes
## Notes
In this project, i used:
1. PHP v8.3
2. Composer v2.10
3. Xdebug v3.5.0
4. roave/security-advisories
5. friendsofphp/php-cs-fixer v3.95
6. phpstan v2.2
7. rector v2.4
8. captainHook v5.29
9. phpunit v13.1
10. mockery v1.6
11. paratest for parallel testing v7.22
12. Docker
