<?php
$Module = $Params["Module"];

//Remove token from preferences
eZPreferences::setValue(eZFlickrConnect::PREF_TOKEN,false);
//Remove authentification from session
$http = new eZHttpTool();
$http->removeSessionVariable("ezflickr_auth");

$Module->redirectToView("connect");
?>