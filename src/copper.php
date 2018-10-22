<?php
/**
 * Copper API
 *
 * @author   Chris Rosenau <chris@magentowizard.com>
 *
 */

declare(strict_types=1);

require "Copper/CopperApi.php";
require "Copper/CopperCompanies.php";
require "Copper/CopperPeople.php";
require "Copper/CopperOpportunity.php";
require "Copper/CopperResponse.php";

use Copper\CopperApi as CopperConnect;
use Copper\CopperResponse as CopperResponse;

// Sign up for a free trial ( https://www.copper.com/ ) and update with your API key and email

$copperApi = new CopperConnect('c591789f706d77f5535a71d2d1060823','developer_api','floweringmind@zoho.com');

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

<?php $copperResponse = new CopperResponse($copperApi); ?>
