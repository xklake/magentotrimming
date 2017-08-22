<?php
function getVideo($url){
	preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
	$youtube_url = $matches[1]; 
	return $youtube_url;
}