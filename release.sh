#!/bin/sh

composer update

VERSION="patch"

run_release() {
  # Testing before release
  echo "Running all tests in order to allow version change";
  ./test.sh;

  echo "Applying a new '$VERSION' version";
  # Committing & pushing everything (including untracked files & version tags) to plugin
  git add .; git commit -m "chore: new '$VERSION' version untracked files commit";
  git push -u origin HEAD --tags;
  vendor/bin/conventional-changelog --$VERSION --commit;
  git add .;
  git commit -m "chore(release): new '$VERSION'";
  git push -u origin HEAD --tags;
}

echo "Initial VERSION: $VERSION"
echo "Arguments: $@"

while [ $# -gt 0 ]; do
    echo "Processing argument: $1"
    case "$1" in
        --rc) VERSION=rc;;
        --patch) VERSION=patch;;
        --minor) VERSION=minor;;
        --major) VERSION=major;;
        *) echo "Unknown option: $1";;
    esac
    shift
done

run_release
