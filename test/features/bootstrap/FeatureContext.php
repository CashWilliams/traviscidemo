<?php

use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Drupal\DrupalExtension\Context\DrupalContext;
use Drupal\DrupalExtension\Event\EntityEvent;

/**
 * Features context.
 */
class FeatureContext extends DrupalContext {
  /**
   * Initializes context.
   * Every scenario gets its own context object.
   *
   * @param array $parameters context parameters (set them up through behat.yml)
   */
  public function __construct(array $parameters)
  {
      // Initialize your context here
  }

  /**
   * For javascript enabled scenarios, always wait for AJAX before clicking.
   *
   * @BeforeStep @javascript
   */
  public function beforeStep($event) {
    $text = $event->getStep()->getText();
    if (preg_match('/(follow|press|click|submit|select)/i', $text)) {
      $this->iWaitForAjaxToFinish();
    }
  }

  /**
   * For javascript enabled scenarios, always wait for AJAX after clicking.
   *
   * @AfterStep @javascript
   */
  public function afterStep($event) {
    $text = $event->getStep()->getText();
    if (preg_match('/(follow|press|click|submit|select)/i', $text)) {
      $this->iWaitForAjaxToFinish();
    }
  }

  /**
   * Waits some time or until JS condition turns true.
   *
   * @param int $time
   *   Time in milliseconds.
   * @param string  $condition
   *   JS condition.
   * @param int $interval
   *   Interval in milliseconds.
   *
   * @return bool
   *   Success.
   *
   * @see Selenium2Driver->wait()
   */
  public function wait($time, $condition, $interval = 1000) {
    $script = "return $condition;";
    $start  = microtime(TRUE);
    $end    = $start + $time / 1000.0;

    do {
      $result = $this->getSession()->evaluateScript($script);
      usleep($interval * 1000);
    } while (microtime(TRUE) < $end && !$result);

    return (bool) $result;
  }

  /**
   * Determine if the a user is already logged in.
   */
  public function loggedIn() {
    $session = $this->getSession();
    $session->visit($this->locatePath('/'));

    $page = $session->getPage();
    //Using the body class logged-in to determine if user is logged in or not
    return $page->find('css', '.logged-in');
  }

  /**
   * @Given /^I take a screenshot named "([^\']*)"$/
   *
   * @javascript
   */
  public function iTakeAScreenshotNamed($fileName) {
    $image = $this->getSession()->getScreenshot();
    file_put_contents($fileName, $image);
  }

  /**
   * @Given /^I dump the html of the page$/
   */
  public function iDumpTheHtmlOfThePage() {
    print_r($this->getSession()->getPage()->getHtml());
  }

  /**
   * @When /^I visit the last created node$/
   */
  public function iVisitTheLastCreatedNode() {
    $nodes = node_get_recent(1);
    $nids = array_keys($nodes);
    if (empty($nids)) {
      throw new Exception(sprintf('No nodes found.'));
    }
    $nid = $nids[0];
    $this->getSession()->visit($this->locatePath('/node/' . $nid));
  }

  /**
   * @When /^I edit the last created node$/
   */
  public function iEditTheLastCreatedNode() {
    $nodes = node_get_recent(1);
    $nids = array_keys($nodes);
    if (empty($nids)) {
      throw new Exception(sprintf('No nodes found.'));
    }
    $nid = $nids[0];
    $this->getSession()->visit($this->locatePath('/node/' . $nid . '/edit'));
  }
}
