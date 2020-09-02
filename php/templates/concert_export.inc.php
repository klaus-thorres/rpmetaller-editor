<?php

if (isset($this->_['header'])) {
	echo $this->_['month_changer'];
	echo '<div id="inhalt" class="inhalt_small">';
	echo nl2br(htmlspecialchars($this->_['header'], ENT_QUOTES));
}

foreach($this->_['concerts'] as $concert) {
	if (!isset($this->_['header']) OR (isset($this->_['header']) AND !isset($concert['nazi']))) { 
		//Build the list of bands
		$bands = '';
		foreach($concert['bands'] as $band) {
			if ($band['zusatz'] != '') {
				$bands = $bands . sprintf('%1$s (%2$s), ', 
					htmlspecialchars($band['name'], ENT_QUOTES),
					htmlspecialchars($band['zusatz'], ENT_QUOTES));
			}
			else {
				$bands = $bands . sprintf('%1$s, ', 
					htmlspecialchars($band['name'], ENT_QUOTES));
			}
		}
		$bands = substr($bands, 0, -2);
		echo "<p ondblclick=\"selectElmCnt(this)\">* ";
		if ($concert['ausverkauft'] == 1) {
			echo '(ausverkauft) ';
		}	
		echo $concert['date_human'] . ' ';
		if ($concert['concert_name'] != '') {
			echo htmlspecialchars($concert['concert_name'], ENT_QUOTES) . ', ';
		}
		echo ' ' . htmlspecialchars($concert['venue_name'], ENT_QUOTES) . ' in  ' . 
			htmlspecialchars($concert['city_name'], ENT_QUOTES) . ":<br>";
		echo '&nbsp;&nbsp;' . $bands . '.<br/>';	
		echo '&nbsp;&nbsp;' . htmlspecialchars($concert['url'], ENT_QUOTES) . "</p>\n";
	}
}
if (isset($this->_['header'])) {
	echo nl2br(htmlspecialchars($this->_['footer'], ENT_QUOTES));
	echo '</div>';
}
?>
