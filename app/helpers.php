<?php
/* this contains some helper functions
i should move it into the correct place in /libraries folder
but at the moment don't have time to figure out correct way 
how to do it */

public function jsDebug($strToDebug)
{
	if (!isset($GLOBALS['_DEBUG'])) $GLOBALS['_DEBUG']=$strToDebug;
	else $GLOBALS['_DEBUG'] .= $strToDebug . "<br>";
}

?>