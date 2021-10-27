<?php

$filename = '149317.xml';
$filename = 'bhltitle.mods.xml';

$state = 0;

$xml = '';

echo "id\ttitle\trelated\tdoi\tissn\twikidata\n";

$file_handle = fopen($filename, "r");
while (!feof($file_handle)) 
{
	$line = trim(fgets($file_handle));
	
	
	if (preg_match('/^<mods/', $line))
	{
		$state = 1;
		$xml = $line . "\n";;
	} 
	else 
	{
		if (preg_match('/^<\/mods>/', $line))
		{
			$xml .= $line . "\n";
			// echo $xml;
			
			
			// do stuff
			
			$row = array();

			$dom= new DOMDocument;
			$dom->loadXML($xml);
			$xpath = new DOMXPath($dom);
			
			$xpath->registerNamespace('mods', 'http://www.loc.gov/mods/v3');
			
			// id
			$xpath_query = '/mods:mods/mods:identifier[@type="uri"]';
			$nodeCollection = $xpath->query ($xpath_query);
			foreach($nodeCollection as $node)
			{
				//echo $node->firstChild->nodeValue . "\n";
				$row['id'] = str_replace('https://www.biodiversitylibrary.org/bibliography/', '', $node->firstChild->nodeValue);
			}
			
			// title
			$xpath_query = '/mods:mods/mods:titleInfo/mods:title[1]';
			$nodeCollection = $xpath->query ($xpath_query);
			foreach($nodeCollection as $node)
			{
				$row['title'] = $node->firstChild->nodeValue;
			}
			
			// related
			$related = '';
	
			$xpath_query = '/mods:mods/mods:relatedItem[1]/mods:titleInfo/mods:title[1]';
			$nodeCollection = $xpath->query ($xpath_query);
			foreach($nodeCollection as $node)
			{
				$related = $node->firstChild->nodeValue;
			}
			$row['related'] = $related;
			
			// doi
			$doi = '';
			
			$xpath_query = '/mods:mods/mods:identifier[@type="doi"]';
			$nodeCollection = $xpath->query ($xpath_query);
			foreach($nodeCollection as $node)
			{
				$doi = $node->firstChild->nodeValue;
			}
			$row['doi'] = $doi;
		
			
			// issn
			$issn = '';
			
			$xpath_query = '/mods:mods/mods:identifier[@type="issn"]';
			$nodeCollection = $xpath->query ($xpath_query);
			foreach($nodeCollection as $node)
			{
				$issn = $node->firstChild->nodeValue;
			}
			$row['issn'] = $issn;
			
			
			// wikidata
			$wikidata = '';
			$row['wikidata'] = $wikidata;
			
			//<identifier type="uri">https://www.biodiversitylibrary.org/bibliography/149317</identifier>

			//print_r($row);
			
			echo join("\t", $row) . "\n";
			
			// get id
			
			// get related
			
			//echo "-----\n\n";
		
			$state = 0;
			$xml = '';
		}
		else
		{
			if ($state == 1)
			{
				$xml .= $line . "\n";
			}
		
		}
	}

	
}	







?>

