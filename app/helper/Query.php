<?php
include "DBConnection.php";

trait Query
{
    use DBConnection;
    public function select_list($query)
    {
        $conn = $this->connect();
        if (!$conn->query($query)) {
            echo "Error Description:" . $conn->error . "<br>";
        } else {
            $result = $conn->query($query); //return value -> mysqli boject
        }
        $this->disconnect($conn);
        return $result;
    }

    public function select_record($query)
    {
        $conn = $this->connect();
        if (!$conn->query($query)) {
            echo "Error Description:" . $conn->error . "<br>";
        } else {
            $result = $conn->query($query);
        }
        $this->disconnect($conn);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        }
    }

    public function insert($tableName, $data)
    {
        // echo $tableName . "<br>";
        // print_r($data);

        $fieldsArray = array_keys($data);
        $valuesArray = array_values($data);

        $fields = "";
        $fields .= "(";
        foreach ($fieldsArray as $field) {
            $fields .= $field . ",";
        }
        $fields = substr($fields, 0, -1);
        $fields .= ")";
        //echo $fields;

        $values = "";
        $values .= "(";
        foreach ($valuesArray as $value) {
            $values .= "'" . $value . "',";
        }
        $values = substr($values, 0, -1);
        $values .= ")";
        //echo $values;

        $query = "insert into {$tableName} {$fields} values {$values}";
        echo $query;

        $conn = $this->connect();
        //echo $conn->query($query); //return value-> true
        if ($conn->query($query) === FALSE) {
            echo "Error Message <b> {$query}</b>.<br>{$conn->error}";
        } else {
            //$conn->query($query);
        }

        $this->disconnect($conn);
    }

    public function delete($tableName, $condation)
    {
        $conn = $this->connect();
        $query = "delete from {$tableName} {$condation}";
        if ($conn->query($query) === FALSE) {
            echo "Error Message <b> {$query}</b>.<br>{$conn->error}";
        }
        $this->disconnect($conn);
    }

    public function update($tableName, $data, $condation)
    {
        // echo $tableName . "<br>";
        // print_r($data);
        // echo $condation;

        $setData = "";
        foreach ($data as $key => $value) {
            $setData .= $key . "='" . $value . "',";
        }
        $setData = substr($setData, 0, -1);
        //print_r($setData);
        $query = "update {$tableName} set {$setData} {$condation}";
        echo $query;
        $conn = $this->connect();
        if ($conn->query($query) === FALSE) {
            echo "Error Message <b> {$query}</b>.<br>{$conn->error}";
        }
        $this->disconnect($conn);
    }
}
