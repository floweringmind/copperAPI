<?php
namespace Copper;

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
