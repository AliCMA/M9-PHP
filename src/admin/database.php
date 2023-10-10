<?php

class Database
{
    private $connection;

    public function __construct($db_server, $db_user, $db_password, $db_name)
    {
        $this->connection = new mysqli($db_server, $db_user, $db_password, $db_name);
        if ($this->connection->connect_error) {
            die('There was a problem connecting to the database.');
        }
    }

    public function query($sql)
    {
        $result = $this->connection->query($sql);

        if (!$result) {
            return ['error' => $this->connection->error];
        }

        $results = [];

        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        return $results;
    }

    public function insertQuery($data, $table)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->connection->prepare($query);

        if (!$stmt) {
            return ['error' => $this->connection->error];
        }

        $types = str_repeat('s', count($data));
        $values = array_values($data);

        $stmt->bind_param($types, ...$values);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return ['message' => 'Record created'];
        } else {
            return ['error' => 'Failed to create record'];
        }
    }

    public function updateQuery($data, $id, $table)
    {
        $setStatements = implode('=?, ', array_keys($data)) . '=?';
        $query = "UPDATE $table SET $setStatements WHERE id=?";

        $stmt = $this->connection->prepare($query);

        if (!$stmt) {
            return ['error' => $this->connection->error];
        }

        $types = str_repeat('s', count($data)) . 'i';
        $values = array_merge(array_values($data), [$id]);

        $stmt->bind_param($types, ...$values);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return ['message' => 'Record updated'];
        } else {
            return ['error' => 'Failed to update record'];
        }
    }

    public function deleteQuery($table, $id)
    {
        $query = "DELETE FROM $table WHERE id=? LIMIT 1";

        $stmt = $this->connection->prepare($query);

        if (!$stmt) {
            return ['error' => $this->connection->error];
        }

        $stmt->bind_param('i', $id);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return ['message' => 'Record deleted'];
        } else {
            return ['error' => 'Failed to delete record'];
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}
