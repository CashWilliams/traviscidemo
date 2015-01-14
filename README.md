[![Build Status](https://travis-ci.org/CashWilliams/traviscidemo.svg?branch=master)](https://travis-ci.org/CashWilliams/traviscidemo)

# Travis CI Demo

This is an end to end demo of a Drupal site in development on Github, with Behat tests running on TravisCI, shipping to an Acquia hosted server.

*For local development, run*

    ant drush-make
    ant link
    ant behat

*Travis CI Runs*

    ant drush-make
    ant rsync
    ant behat
