<?php

	# CLEAN TEXT DATA
	function CleanData(&$String)
	{
		$String = preg_replace("/\t/", "\\t", $String);
		$String = preg_replace("/\r?\n/", "\\n", $String);
		
		if (strstr($String, '"')){ $String = '"' . str_replace('"', '""', $String) . '"'; }
	}
	
	# EXAMPLE DATA SET WITHIN ARRAY
	$Data = [
		'ColumnOne' => 'Some Information',
		'ColumnTwo' => 'More Some Information',
		'ColumnThree' => 'Even More Information'
	];

	# DOWNLOADED FILE NAME
	$FileName = "ExcelExample.xls";
	
	# SET HEADER
	$Content = '';
  $HeaderSet = FALSE;
	
	# LOOP EACH VALUE IN DATA ARRAY
	foreach ($Data AS $Row)
	{
		# DISPLAY FIELD/COLUMN NAMES > FIRST ROW
		if (!$HeaderSet)
		{
			$Content .= implode ("\t", array_keys($Row)) . "\r\n";
			$HeaderSet = TRUE;
		}
		
		# WRITE ROWS
		array_walk($Row, __NAMESPACE__ . '\CleanData');
		$Content .= implode ("\t", array_values($Row)) . "\r\n";
	}
	
	# SERVER URL PATH
	$FilePath = 'Documents/'.$FileName;
	
	# ATTEMPT TO CREATE/OPEN NEW FILE OR KILL SCRIPT
	$FileHandle = fopen("$FilePath", "w") or die("Unable To Open File ...");
	
	# WRITE CONTENT TO FILE & CLOSE CONNECTION
	fwrite($FileHandle, $Content);
	fclose($FileHandle);
	
?>
