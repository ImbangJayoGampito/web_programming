<?php

include_once './config/Database.php';


abstract class Model
{
    protected static string $table; // Database table name  
    public static function getSorted(string $fieldName, string $order = "ASC")
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " ORDER BY $fieldName $order");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            // Map each record to an object
            $objects = array_map([static::class, 'mapToObject'], $data);
            return $objects; // Return an array of objects
        } else {
            return [];
        }
    }

    public static function find(string $fieldName, mixed $value)
    {
        $db = DB::getInstance()->getConnection();

        // Use prepared statements to prevent SQL injection
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE $fieldName = :val");

        try {
            // Execute the query with the provided value
            $stmt->execute(['val' => $value]);

            // Fetch the result as an associative array
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if data exists
            if ($data === false) {
                return null; // Return null if no record is found
            }

            // Map the result to an object
            return static::mapToObject($data);
        } catch (PDOException $e) {
            // Handle any database errors
            error_log("Database error in find(): " . $e->getMessage());
            return null;
        }
    }
    public static function find_all(string $fieldName, mixed $value)
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE $fieldName = :val");
        $stmt->execute(['val' => $value]);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        var_dump($stmt);
        if ($data) {
            // Map each record to an object
            $objects = array_map([static::class, 'mapToObject'], $data);
            $objects; // Return an array of objects
        } else {
            return [];
        }
    }
    public static function get_all()
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM " . static::$table);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            // Map each record to an object
            $objects = array_map([static::class, 'mapToObject'], $data);
            return $objects; // Return an array of objects
        } else {
            return null;
        }
    }

    public function save(): bool
    {
        $db = DB::getInstance()->getConnection();
        $fields = get_object_vars($this);
        $columns = array_keys($fields);

        if (isset($this->id)) {
            // Update record  
            $query = "UPDATE " . static::$table . " SET " . implode(", ", array_map(fn($col) => "$col = :$col", $columns)) . " WHERE id = :id";
        } else {
            // Insert new record  
            $query = "INSERT INTO " . static::$table . " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", array_map(fn($col) => ":$col", $columns)) . ")";
        }

        $stmt = $db->prepare($query);
        return $stmt->execute($fields);
    }
    public function deleteAt(string $fieldName, mixed $value)
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM " . static::$table . " WHERE $fieldName = :val");
        return $stmt->execute(['val' => $value]);
    }

    private static function mapToObject(array $data): static
    {
        $object = new static();
        foreach ($data as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }
}
