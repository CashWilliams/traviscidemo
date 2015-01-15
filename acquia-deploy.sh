#!/bin/bash

echo "- Acquia Deploy Starting -"

if ${ACQUIA_DISABLE_DEPLOY:-false}; then
  echo "Acquia deploy disabled"
  exit 0
fi

if $TRAVIS_PULL_REQUEST; then
  echo "Pull requests do not get deployed"
  exit 0
fi

# travis will have unencrypted the ssh key for us from travis_id_rsa.enc
chmod 600 travis_id_rsa
ssh-add travis_id_rsa

# add acquia host to known ssh hosts
ACQUIA_HOST=$(echo $ACQUIA_REPO | awk '{split($0, arr, "[@:]"); print arr[2]}')
ssh-keyscan $ACQUIA_HOST >> ~/.ssh/known_hosts

# clone acquia repo as /build_deploy
git clone -b $TRAVIS_BRANCH $ACQUIA_REPO build_deploy
rsync -a --delete build build_deploy

cd build_deploy
# git add -A should remove no longer used files
git add -A .
git commit -m "Travis CI build" 
git push acquia $TRAVIS_BRANCH 

echo "- Acquia Deploy Complete -"
