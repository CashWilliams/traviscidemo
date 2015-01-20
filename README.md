[![Build Status](https://travis-ci.org/CashWilliams/traviscidemo.svg?branch=master)](https://travis-ci.org/CashWilliams/traviscidemo)

# Travis CI Demo

This is an end to end demo of a Drupal site in development on Github, with Behat tests running on TravisCI, shipping to an Acquia hosted server.

## Demo

Travis CI builds and deploys this project to Acquia servers, which can be seen here:

- Dev (development branch) http://traviscidemojvbxicnsx2.devcloud.acquia-sites.com
- Stage (master branch) http://traviscidemodknlcr3ym3.devcloud.acquia-sites.com

# Installation

*To install and develop locally, run*

    ant drush-make
    ant link
    ant behat

*Travis CI runs this*

    ant run-tests
