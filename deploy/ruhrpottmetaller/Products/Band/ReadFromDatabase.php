<?php

namespace ruhrpottmetaller\Products\Band;

use mysqli;
use mysqli_stmt;
use ruhrpottmetaller\Products\AbstractReadFromDatabase;

class ReadFromDatabase extends AbstractReadFromDatabase
{
    protected function getPreparedMysqliStatement(mysqli $mysqli, array $filters): mysqli_stmt
    {
        if (isset($this->filters['id'])) {
            $mysqliStatement = $this->getPreparedMysqliStatementFilterById(mysqli: $mysqli, id: $filters['id']);
        } elseif (!isset($this->filters['first_character']) or $filters['first_character'] == '') {
            $mysqliStatement = $this->getPreparedMysqliStatementNoFilter(mysqli: $mysqli);
        } elseif ($filters['first_character'] == '%') {
            $mysqliStatement = $this->getPreparedMysqliStatementFirstCharIsSpecialCharacter(
                mysqli: $mysqli,
            );
        } else {
            $mysqliStatement = $this->getPreparedMysqliStatementFirstCharIsNormalLetter(
                mysqli: $mysqli,
                first_character:  $filters['first_character']
            );
        }
        return $mysqliStatement;
    }

    private function getPreparedMysqliStatementFilterById(mysqli $mysqli, int $id):mysqli_stmt
    {
        $statement = $mysqli->prepare('SELECT id, name, visible FROM band WHERE id = ? ORDER BY name');
        $statement->bind_param('i', $id);
        return $statement;
    }

    private function getPreparedMysqliStatementNoFilter(mysqli $mysqli): mysqli_stmt
    {
        return $mysqli->prepare('SELECT id, name, visible FROM band ORDER BY name');
    }

    private function getPreparedMysqliStatementFirstCharIsSpecialCharacter(mysqli $mysqli):mysqli_stmt
    {
        return $mysqli->prepare('SELECT id, name, visible from band WHERE name NOT REGEXP "^[A-Z,a-z]"'
            . ' ORDER BY name;');
    }

    private function getPreparedMysqliStatementFirstCharIsNormalLetter(
        mysqli $mysqli,
        string $first_character
    ):mysqli_stmt {
        $statement = $mysqli->prepare('SELECT id, name, visible FROM band WHERE name = ? ORDER BY name');
        $first_character .= '%';
        $statement->bind_param('s', $first_character);
        return $statement;
    }
}