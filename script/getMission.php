<?php 
session_start();
require_once __DIR__ . "/../services/MissionService.php";
require_once __DIR__ . "/../services/UserService.php";

$m = MissionService::getInstance();
$u = UserService::getInstance();
if (isset($_POST['mission'])) {
	$mission = $m->get($_POST['mission']);
	?>
	<div class="row justify-content-center">
	  <div class="col-lg-10">
	    <div class="box">
	      <h2><b><?= $mission->getTitle();?></b></h2>
	      <h3><i class="<?= $mission->getLogo();?>"></i></h3>
	      <p class="description">
	      	<?= $mission->getDescription();?>
	      </p>
	    </div>
	  </div>
	</div>
	<?php
}