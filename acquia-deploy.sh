#!/bin/bash

echo "- Acquia Deploy Starting -"

# trace execution
set -x

# lets dump all enviroement variables
printenv 


if ${ACQUIA_DISABLE_DEPLOY:-false}; then
  echo "Acquia deploy disabled"
  exit 0
fi

if [ -n "$TRAVIS_PULL_REQUEST" ]; then
  echo "Pull requests do not get deployed"
  exit 0
fi

# Start ssh-agent http://stackoverflow.com/questions/17846529/could-not-open-a-connection-to-your-authentication-agent
eval `ssh-agent -s`

# Add key that is decrypted in .travis.yml
chmod 600 travis_rsa
ssh-add travis_rsa

# add acquia host to known ssh hosts
ACQUIA_HOST=$(echo $ACQUIA_REPO | awk '{split($0, arr, "[@:]"); print arr[2]}')
ssh-keyscan $ACQUIA_HOST >> ~/.ssh/known_hosts

# list sshs for debugging
echo "SSH Keys Avaiable"
ssh-add -l

# clone acquia repo as /build_deploy
git clone -vb $TRAVIS_BRANCH $ACQUIA_REPO build_deploy
# TODO: This needs use variables
git config --global user.email "CashWilliams@gmail.com"
git config --global user.name "Travis CI"

# rsync build into cloned repo
# TODO: This needs to be more generic
rsync -avh --delete build/docroot build_deploy
rsync -avh --delete build/hooks build_deploy

cd build_deploy
# git add -A should remove no longer used files
git add -A .
for DIR in docroot/sites/*; do
  if [ -d "${DIR}" ]; then
    if [ "$DIR" != "docroot/sites/all" ]; then
      git add -f $DIR/settings.php
    fi
  fi
done
NOW=$(date +"%Y-%m-%d %H:%M:%S")
git commit -m "$TRAVIS_BRANCH #$TRAVIS_BUILD_NUMBER $NOW $TRAVIS_COMMIT" 
git push origin $TRAVIS_BRANCH 

set +x
echo "- Acquia Deploy Complete -"
