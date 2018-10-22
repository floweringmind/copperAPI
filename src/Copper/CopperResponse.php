<?php
namespace Copper;

use Copper\CopperCompanies as CopperCompanies;

class CopperResponse
{
  protected $copperApi;
  private $target, $action;

  public function __construct(copperApi $copperApi)
  {
    $target = $_GET['target'];
    $action = $_GET['action'];
    $this->makeChoice($copperApi, $target, $action);
  }

  private function makeChoice(copperApi $copperApi, $target, $action)
  {
    $copperCompanies = new CopperCompanies($copperApi);
    $copperPeople = new copperPeople($copperApi);
    $copperOpportunity = new copperOpportunity($copperApi);
    
    switch($target) {
      case "companies":
        $this->getCompanies($action, $copperCompanies);
        break;
      case "people":
        $this->getPeople($action, $copperCompanies, $copperPeople);
        break;
      case "opportunities":
        $this->getOpportunities($action, $copperPeople, $copperOpportunity);
    }
  }

  public function getCompanies($action, $copperCompanies)
  {
    if ($action == 'search') {
        $companies = $copperCompanies->findCompanies(25, 'name');
        echo '<h2>Listing All Companies</h2>';
        echo '<h3>Response:</h3>';
        echo '<pre>';var_dump($companies).'</pre>';
    } else {
      echo "Error: Action as been modified.";
    }
  }

  public function getPeople($action, $copperCompanies, $copperPeople)
  {
    $companies = $copperCompanies->findCompanies(25, 'name');
    $company_id = $copperCompanies->getCompanyId($companies, 'Dunder Mifflin');
    $personFound = $copperPeople->findPerson('Pam Beesley');
    $userId = $personFound[0]['id'];
    $people = 'People';
    $userChange = array();

    if ($action == 'create' && !$userId) {
      $copperPeople->createPerson($company_id, 'Pam Beesley', 'mycontact_1233@noemail.com', 'work', '415-123-45678', 'mobile');
      $action = 'search';
      $people = 'People with new user Pam Beesley';
    }elseif ($action == 'create' &&  $userId){
      $action = 'search';
      $people = 'People And Pam Beesley Is Already Created';
    }


    if ($action == 'update' &&  $userId) {
      $copperPeople->updateName($userId, "Pam Halpert");
      $action = 'search';
      $people = 'People with updated user Pam Beesley';
    }elseif ($action == 'create' && !$userId) {
      $action = 'search';
      $people = 'People And Pam Beesley Was Not Found';
    }

    if ($action == 'search') {
      $foundPeople = $copperPeople->findPeople(25, 'name');
      echo '<h2>Listing All '.$people.' For Company Dunder Mifflin</h2>';
      echo '<h3>Response:</h3>';
      echo '<pre>';var_dump($foundPeople).'</pre>';
    }
  }

  public function getOpportunities($action, $copperPeople, $copperOpportunity)
  {
    $personFound = $copperPeople->findPerson('Pam Halpert');
    $userId = $personFound[0]['id'];
    $opportunities = 'Opportunities';

    if ($userId == "") {
        echo "<h3>Please First Run Update People -> Update.</h3>";
    }

    if ($action == 'create' && $userId) {
      $copperOpportunity->createOpportunity($userId, "sell secratary supplies");
      $action = 'search';
      $opportunities = 'Opportunities And Opportunity Sell Secratary Supplies';
    }

    if ($action == 'search') {
      $foundOpportunities = $copperOpportunity->findOpportunities(25, 'name');
      echo '<h2>Listing All '.$opportunities.' For Company Dunder Mifflin</h2>';
      echo '<h3>Response:</h3>';
      echo '<pre>';var_dump($foundOpportunities).'</pre>';
    }
  }
}
