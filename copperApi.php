<?php

/**
 * Copper API
 *
 * @author   Chris Rosenau <chris@magentowizard.com>
 *
 */
?>

<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">

<h1>Copper API Example</h1>
<p>Copper is a new kind of productivity crm that's designed to do all your busywork, so you can focus on building long-lasting business relationships.</p>
<p>This is an example of using the Copper API.</p>

<div class="pure-menu pure-menu-horizontal" style="max-height:200px;overflow: hidden">
    <ul class="pure-menu-list">
        <li class="pure-menu-item pure-menu-selected"><a href="https://www.copper.com/" target="_blank" class="pure-menu-link">Copper Homepage</a></li>
        <li class="pure-menu-item pure-menu-has-children pure-menu-allow-hover">
            <a href="#" id="menuLink1" class="pure-menu-link">Companies</a>
            <ul class="pure-menu-children">
                <li class="pure-menu-item"><a href="?target=companies&action=search" class="pure-menu-link">Search</a></li>
            </ul>
        </li>
        <li class="pure-menu-item pure-menu-has-children pure-menu-allow-hover">
            <a href="#" id="menuLink1" class="pure-menu-link">People</a>
            <ul class="pure-menu-children">
                <li class="pure-menu-item"><a href="?target=people&action=search" class="pure-menu-link">Search</a></li>
                <li class="pure-menu-item"><a href="?target=people&action=create" class="pure-menu-link">Create</a></li>
                <li class="pure-menu-item"><a href="?target=people&action=update" class="pure-menu-link">Update</a></li>
            </ul>
        </li>        
        <li class="pure-menu-item pure-menu-has-children pure-menu-allow-hover">
            <a href="#" id="menuLink1" class="pure-menu-link">Opportunities</a>
            <ul class="pure-menu-children">
                <li class="pure-menu-item"><a href="?target=opportunities&action=search" class="pure-menu-link">Search</a></li>
                <li class="pure-menu-item"><a href="?target=opportunities&action=create" class="pure-menu-link">Create</a></li>
            </ul>
        </li>           
    </ul>
</div>

<?php

// Sign up for a free trial ( https://www.copper.com/ ) and update with your API key and email

$copperApi = new copperApi('c591789f706d77f5535a71d2d1060823','developer_api','floweringmind@zoho.com');

$target = $_GET['target'];
$action = $_GET['action'];

// ***************************
//- companies methods -
// ***************************

if ($target == 'companies' && $action == 'search')
{
    $copperCompanies = new copperCompanies($copperApi);
    $companies = $copperCompanies->findCompanies(25, 'name');

    echo '<h2>Listing All Companies</h2>';
    echo '<h3>Response:</h3>';
    echo '<pre>';var_dump($companies).'</pre>';
}


// ***************************
//- people methods -
// ***************************

if ($target == 'people')
{
    $copperCompanies = new copperCompanies($copperApi);
    $companies = $copperCompanies->findCompanies(25, 'name');
    $company_id = $copperCompanies->getCompanyId($companies, 'Dunder Mifflin');

    $copperPeople = new copperPeople($copperApi);
    $personFound = $copperPeople->findPerson('Pam Beesley');
    $userId = $personFound[0]['id'];

    $people = 'People';
    $userChange = array();

    if ($action == 'create' && !$userId)
    {    

        $copperPeople->createPerson($company_id, 'Pam Beesley', 'mycontact_1233@noemail.com', 'work', '415-123-45678', 'mobile');
        $action = 'search';
        $people = 'People with new user Pam Beesley';

    }elseif ($action == 'create' &&  $userId)
    {

        $action = 'search';
        $people = 'People And Pam Beesley Is Already Created';

    }


    if ($action == 'update' &&  $userId)
    {   

        $copperPeople->updateName($userId, "Pam Halpert");
        $action = 'search';
        $people = 'People with updated user Pam Beesley';

    }elseif ($action == 'create' && !$userId)
    {

        $action = 'search';
        $people = 'People And Pam Beesley Was Not Found';

    }

    if ($action == 'search')
    {

        $foundPeople = $copperPeople->findPeople(25, 'name');
        echo '<h2>Listing All '.$people.' For Company Dunder Mifflin</h2>';
        echo '<h3>Response:</h3>';        
        echo '<pre>';var_dump($foundPeople).'</pre>';

    }
}

// ***************************
//- opportunity methods -
// ***************************

if ($target == 'opportunities')
{

    $copperPeople = new copperPeople($copperApi);
    $personFound = $copperPeople->findPerson('Pam Halpert');
    $userId = $personFound[0]['id'];

    $copperOpportunity = new copperOpportunity($copperApi);
    $opportunities = 'Opportunities';

    if ($userId == ""){
        echo "<h3>Please First Run Update People -> Update.</h3>";
    }

    if ($action == 'create' && $userId)
    {

    	$copperOpportunity->createOpportunity($userId, "sell secratary supplies");

        $action = 'search';
        $opportunities = 'Opportunities And Opportunity Sell Secratary Supplies';
    }

    if ($action == 'search')
    {

        $foundOpportunities = $copperOpportunity->findOpportunities(25, 'name');
        echo '<h2>Listing All '.$opportunities.' For Company Dunder Mifflin</h2>';
        echo '<h3>Response:</h3>';        
        echo '<pre>';var_dump($foundOpportunities).'</pre>';

    }

}




class copperApi
{
	private $apiKey;
	private $application;
	private $devEmail;

    public function __construct($apiKey, $application, $devEmail)
    {

    	$this->apiKey = $apiKey;
    	$this->application = $application;
    	$this->devEmail = $devEmail;

    }

    public function copperConnect($dataCall, $callType, $callFields)
    {
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.prosperworks.com/developer_api/v1/$dataCall",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => $callType,
		  CURLOPT_POSTFIELDS => $callFields,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		    "X-PW-AccessToken: ".$this->apiKey,
		    "X-PW-Application: ".$this->application,
		    "X-PW-UserEmail: ".$this->devEmail
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		  die();
		} else {
		  return $response;
		}    	
    }
}

class copperCompanies
{

	protected $copperApi;

	 public function __construct(copperApi $copperApi)
	 {
	 	$this->copperApi = $copperApi;
	 }

    public function findCompanies($numRecords, $sortBy)
    {
    	$dataCall = 'companies/search';
    	$callFields = array('page_size' => $numRecords, 'sort_by' => $sortBy);
    	$callFields = json_encode($callFields);
    	$response = $this->copperApi->copperConnect($dataCall, 'POST', $callFields);
    	$jasonData = json_decode($response, true);
    	return $jasonData;
    }

    public function getCompanyId($companies, $companyName)
    {
    	foreach ($companies as $company) {
    		if (strpos($company['name'], $companyName) !== false)
    		{
    			return $company['id'];
    		}
    	}
    } 

}

class copperPeople
{

	private $copperApi;

    public function __construct(copperApi $copperApi)
    {
    	$this->copperApi = $copperApi;
    }


    public function findPeople($numRecords, $sortBy)
    {
    	$dataCall = 'people/search';
    	$callFields = array('page_size' => $numRecords, 'sort_by' => $sortBy);
    	$callFields = json_encode($callFields);
    	$response = $this->copperApi->copperConnect($dataCall, 'POST', $callFields);
    	$jasonData = json_decode($response, true);
    	return $jasonData;    	
    }   

    public function findPerson($name)
    {
    	$dataCall = 'people/search';
    	$callFields = array('name' => $name);
    	$callFields = json_encode($callFields);
    	$response = $this->copperApi->copperConnect($dataCall, 'POST', $callFields);
    	$jasonData = json_decode($response, true);
    	return $jasonData;   
    }      


    public function createPerson( $companyId, $userName,  $userEmail, $emailCategory, $phoneNumber, $phoneCategory)
    {
    	$dataCall = 'people';

		$callFields = [
		"name" => $userName,
		"company_id" => $companyId,
		"emails" => [ 
		["email" => $userEmail, "category" => $emailCategory]
		],
		"phone_numbers" => [
		["number" => $phoneNumber,"category" => $phoneCategory]
		]];

    	$callFields = json_encode($callFields);

    	$response = $this->copperApi->copperConnect($dataCall, 'POST', $callFields);
    }    

    public function updateName( $userId, $newName)
    {
    	$userId = $userId;
    	$dataCall = 'people/'.$userId;

		$callFields = [
		"name" => $newName
		];

    	$callFields = json_encode($callFields);

    	$response = $this->copperApi->copperConnect($dataCall, 'PUT', $callFields);
    } 
}

class copperOpportunity
{

    private $copperApi;

    public function __construct(copperApi $copperApi)
    {
    	$this->copperApi = $copperApi;
    }
    
    public function createOpportunity($primeId, $name)
    {
        $dataCall = 'opportunities';

        $callFields = [
        "name" => $name,
        "primary_contact_id" => $primeId
        ];

        $callFields = json_encode($callFields);
        $response = $this->copperApi->copperConnect($dataCall, 'POST', $callFields);

    } 

    public function findOpportunities($numRecords, $sortBy)
    {
    	$dataCall = 'opportunities/search';
        $callFields = array('page_size' => $numRecords, 'sort_by' => $sortBy);
    	$callFields = json_encode($callFields);
        $response = $this->copperApi->copperConnect($dataCall, 'POST', $callFields);
        $jasonData = json_decode($response, true);
        return $jasonData;
    }             
}
