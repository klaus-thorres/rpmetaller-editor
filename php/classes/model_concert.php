<?php

/**
 * Class to access and manipulate the data in the event table and the event_band table
 * Version 1.0.0
 */
class ConcertModel {
	//Link identifier for the connection to the database
	private $mysqli = NULL;

	/**
	 * Call the function which initialize the database connection and write the link
	 * identifier into the class variable.
	 */
	public function __construct() {
		$mysqli = ConnectModel::db_conncect();
		$this->mysqli = $mysqli;
	}
	
	/**
	 * Close the database connection.
	 */
	public function __destruct() {
		$this->mysqli->close;
	}

	/**
	 * Read data about concerts in a specified month from the database and deliver it as a 
	 * three dimensional array.
	 *
	 * @param string $month Month from which the concert is read.
	 * @return array Array with the concert data. If no concerts are present in this month it
	 * 		returns an empty array. 
	 */
	public function getConcerts($month) {
		$stmt = $this->mysqli->prepare('SELECT event.id, event.datum_beginn, event.datum_ende,
			event.name AS kname, event.url, event.publiziert,
			location.name AS lname, stadt.name AS sname FROM event
			LEFT JOIN location ON event.location_id = location.id
			LEFT JOIN stadt ON location.stadt_id = stadt.id WHERE datum_beginn LIKE ?
			ORDER BY event.datum_beginn ASC');
		$stmt->bind_param('s', $month . '%');
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		//Connect an event with the bands which are playing there.
		$stmt = $this->mysqli->prepare('SELECT band.name, band.nazi, event_band.zusatz FROM event_band
			LEFT JOIN band ON event_band.band_id = band.id WHERE event_band.event_id LIKE ?');
		for($i = 0; $i < count($result); $i++) {
			$stmt->bind_param('i', $id)
			$stmt->execute();
			$bands = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$result[$i]['bands'] = $bands;
		}
		$stmt->close;
		return $result;
	}

	/**
	 * Read the data of one concert from the database and deliver it as a two dimensional array.
	 *
	 * @param integer $id Id of the concert which data is read.
	 * @return array Array with the concert data. If no concert with this id exist it returns 
	 * 		an empty array. 
	 */
	public function getConcert($id) {
		$stmt = $this->mysqli->prepare('SELECT event.id, event.datum_beginn, event.datum_ende,
			event.name AS kname,
			event.url, event.publiziert, location.name AS lname,
			stadt.name AS sname FROM event LEFT JOIN location ON event.location_id = location.id
			LEFT JOIN stadt ON location.stadt_id = stadt.id WHERE event.id = ?
			ORDER BY event.datum_beginn ASC');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}
	
	/**
	 * Update the data of one concert in the database.
	 *
	 * @param integer $id Id of the concert which data is updated.
	 * @param string $name The name of the concert.
	 * @param string $date_start It contains the date on which the concert takes place. If the concert is a 
	 * 	multi-day festival it contains the date of the first day.
	 * @param string $date_end If the concert is a multi-day festival this string contains the date of the last day 
	 * 	in the format YYYY-MM-DD. If it is just on one day, the string is empty.
	 * @param integer $venue_id The id of the venue where the concert takes place
	 * @param string $url URL which links to information about a concert
	 * @return integer Returns 1 for successful operation, 0 for a non-existent id, -1 for an error.
	 */
	public function updateConcert($id, $name, $date_start, $date_end, $venue_id, $url) {
		$stmt = $this->mysqli->prepare('UPDATE event SET name = ?, datum_beginn = ?, datum_ende = ?,
			location_id = ?, url = ? WHERE id = ?');
		$stmt->bind_param('sssisi', $name, $date_start, $date_end, $venue_id, $url, $id);
		$stmt->execute();
		//Check if the query was successfull
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}
	
	/**
	 * Insert a concert into the database.
	 *
	 * @param string $name The name of the concert.
	 * @param string $date_start It contains the date on which the concert takes place. If the concert is a 
	 * 	multi-day festival it contains the date of the first day.
	 * @param string $date_end If the concert is a multi-day festival this string contains the date of the last day 
	 * 	in the format YYYY-MM-DD. If it is just on one day, the string is empty.
	 * @param integer $venue_id The id of the venue where the concert takes place
	 * @param string $url URL which links to information about a concert
	 * @return integer Returns 1 for successful operation or -1 for an error.
	 */
	public function setConcert($name, $date_start, $date_end, $venue_id, $url) {
		$stmt = $this->mysqli->prepare('INSERT INTO event SET name = ?, datum_beginn = ?, datum_ende = ?,
			location_id = ?, url = ?');
		$stmt->bind_param('sssis', $name, $date_start, $date_end, $venue_id, $url);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}
	
	/**
	 * Delete one concert in the database.
	 *
	 * @param integer $id Id of the concert which is deleted.
	 * @return integer Returns 1 for successful operation, 0 for a non-existent id, -1 for an error.
	 */
	public function delConcert($id) {
		$stmt = $this->mysqli->prepare('DELETE event, event_band FROM EVENT
			LEFT JOIN event_band ON event.id=event_band.event_id
			WHERE event.id= ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}

	/**
	 * Retrieve band data of bands which are playing on a concert.
	 *
	 * @param integer $id Id of the concert from which the band data is retrieved.
	 * @return array|integer Array with band id, export bit and additional information about the appearance 
	 * 	of a band, or an integer with -1 in case of an error.
	 */
	public function getBands($id) {
		$stmt = $this->mysqli->prepare('SELECT band.name, band.nazi, event_band.zusatz FROM event_band
			LEFT JOIN band ON event_band.band_id = band.id WHERE event_band.event_id LIKE ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}

	/**
	 * Insert band data of a band which is playing at a concert.
	 *
	 * @param integer id Id of the concert on which the band is playing.
	 * @param integer $band_id Band id of the band which is playing.
	 * @param addition $string Additional information about the appearance.
	 * @return integer Returns 1 for a successful operation, 0 for a non-existent id, -1 for an error.
	 */
	public function setBand($id, $band_id, $addition) {
		$stmt = $this->mysqli->prepare('INSERT INTO event_band SET event_id = ?, band_id = ?, zusatz = ?');
		$stmt->bind_param('iis', $id, $band_id, $addition);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}
	
	/**
	 * Retrieve band data of band which are playing on a concert.
	 *
	 * @param integer $id Id of the concert from which the band data is retrieved.
	 * @return array|integer Array with band id, export bit and additional information about the appearance 
	 * 	of a band, or an integer with -1 in case of an error.
	 */
	public function delBands($id) {
		$stmt = $this->mysqli->prepare('DELETE FROM event_band WHERE event_band.event_id = ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}

	/**
	 * Set a concert as sold out.
	 *
	 * @param integer $id Id of the concert which should be set sold out.
	 * @return integer Returns 1 for a successful operation, 0 for a non-existent id, -1 for an error.
	 */
	public function setSoldOut ($id) {
		$stmt = $this->mysqli->prepare('UPDATE event SET ausverkauft=1 WHERE id = ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}

	/**
	 * Set a concert as published.
	 *
	 * @param integer $id Id of the concert which should be set published.
	 * @return integer Returns 1 for a successful operation, 0 for a non-existent id, -1 for an error.
	 */
	public function setPublished ($id) {
		$stmt = $this->mysqli->prepare('UPDATE event SET publiziert=1 WHERE id= ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}

}
?>
