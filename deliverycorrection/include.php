<?php
CModule::IncludeModule("deliverycorrection");

$arClasses=array(
    'cDeliverycorrection'=>'classes/general/cDeliverycorrection.php'
);

CModule::AddAutoloadClasses("deliverycorrection",$arClasses);
