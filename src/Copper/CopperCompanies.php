<?php
namespace Copper;

class CopperCompanies
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
			if (strpos($company['name'], $companyName) !== false) {
				return $company['id'];
			}
		}
	}
}
