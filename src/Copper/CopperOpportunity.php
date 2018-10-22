<?php
namespace Copper;

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
