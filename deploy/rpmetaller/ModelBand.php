<?php

namespace rpmetaller;

/**
 * Class to acces and manipulate the data in the band table.
 * Version 1.0.0
 */
class ModelBand
{
    //Link identifier for the connection to the database
    private $mysqli = null;

    /**
     * Call the function which initialize the database connection and write the
     * link identifier into the class variable.
     */
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    /**
     * Get band data from the database
     *
     * @param string $initial Initial letter of the band name in capital letters
     *  or an empty string for all bands or a % for bands witch names start with
     *  a special character.
     * @return array Array with band data.
     */
    public function getBands($initial)
    {
        $mysqli = $this->mysqli;
        switch($initial) {
            case '':
                $stmt = $mysqli->prepare('SELECT id, name, visible FROM band
                    ORDER BY name');
                break;
            case '%':
                $stmt = $mysqli->prepare('SELECT id, name, visible from band
                    WHERE name NOT REGEXP "^[A-Z,a-z]" ORDER BY name;');
                break;
            default:
                $stmt = $mysqli->prepare('SELECT id, name, visible FROM band
                    WHERE name LIKE ? ORDER BY name');
                $initial = $initial . '%';
                $stmt->bind_param('s', $initial);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    /**
     * Get band data from one band with the submitted id.
     *
     * @param integer $id Id of the band.
     * @return array Array with band data.
     */
    public function getBand($id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT id, name, visible FROM band WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    /**
     * Insert data about a band into the database
     *
     * @param string $name Name of the band.
     * @param integer $nazi Export status of the band. 0 -> exportable
     *  1-> non-exportable
     * @return integer Returns id of the new band, -1 for an error.
     */
    public function setBand($name)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO band SET name=?');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $mysqli->insert_id;
        $stmt->close();
        return ($result);
    }

    /**
     * Update band data in the database
     *
     * @param integer $id Id of the band which is updated.
     * @param string $name Name of the band.
     * @param integer $nazi Export status of the band. 0 -> exportable
     *  1-> non-exportable
     * @return integer Returns 1 for successful operation,
     *  0 for a non-existent id, -1 for an error.
     */
    public function updateBand($id, $name, $visible)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE band SET name=?, visible=? WHERE id=?');
        $stmt->bind_param('sii', $name, $visible, $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return ($result);
    }
}
