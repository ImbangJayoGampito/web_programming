<?php

declare(strict_types=1);


if (!file_exists(File::getTargetDir())) {
    mkdir(File::getTargetDir(), 0777, true);
}

include_once "helper.php";
class DB
{

    private PDO $conn;
    private static $obj;
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbName = 'uts_webpro';
    private final function __construct()
    {
        $this->conn = tryFail(function () {
            $res = new PDO("mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4", $this->user, $this->pass);
            return $res;
        })->unwrap();
    }
    public function getConnection()
    {
        return $this->conn;
    }
    public static function getInstance()
    {
        if (!isset(self::$obj)) {
            self::$obj = new DB();
        }
        return self::$obj;
    }
}
abstract class Model
{
    protected static string $table; // Database table name  
    public static function getSorted(string $fieldName, string $order = "ASC"): Result
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " ORDER BY $fieldName $order");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            // Map each record to an object
            $objects = array_map([static::class, 'mapToObject'], $data);
            return Result::ok($objects); // Return an array of objects
        } else {
            return Result::err("Can't find any records in table " . static::$table);
        }
    }

    public static function find(string $fieldName, mixed $value): Result
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE $fieldName = :val");
        $stmt->execute(['val' => $value]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? Result::ok(static::mapToObject($data)) : Result::err("Can't find $value in field $fieldName which is in in table " . static::$table);
    }
    public static function find_all(string $fieldName, mixed $value): Result
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE $fieldName = :val");
        $stmt->execute(['val' => $value]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            // Map each record to an object
            $objects = array_map([static::class, 'mapToObject'], $data);
            return Result::ok($objects); // Return an array of objects
        } else {
            return Result::err("Can't find any records with $value in field $fieldName which is in table " . static::$table);
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
            return Result::ok($objects); // Return an array of objects
        } else {
            return Result::err("Can't find any records in table " . static::$table);
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
    public function delete(string $fieldName, mixed $value)
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


class User extends Model
{
    protected static string $table = 'users';

    public int $id;
    public string $username;
    protected string $password;
    protected string $email;
    public function getEmail(): string
    {
        return $this->email;
    }
    public string $created_at;
    public function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[static::getSessionKey()] = $this;
    }
    public static function leadToHome()
    {
        header("Location: index.php");
    }
    public static function getSessionKey(): string
    {
        return 'user_session';
    }
    public static function userInSession(): Result
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION[User::getSessionKey()]) || $_SESSION[User::getSessionKey()] == '') {
            return Result::err("User is not in session!");
        }
        return Validator::isFilled($_SESSION[User::getSessionKey()]);
    }
    public static function inSession(): bool
    {
        return User::userInSession()->isOk;
    }
    public function setUser($username, $password, $email)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->created_at = gmdate("Y-m-d H:i:s");
    }
    public static function login($usernameOrEmail, $password, &$userEmailError, &$passwordError)
    {
        $userRes = null;
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            $userRes = User::find('email', $usernameOrEmail);
        } else {
            $userRes = User::find('username', $usernameOrEmail);
        }
        if (!$userRes->isOk) {
            $userEmailError = "Account does not exist!";
            return;
        }
        $user = $userRes->unwrap();
        if (!password_verify($password, $user->password)) {
            $passwordError = "Password does not match!";
            return;
        }
        $user_session = new User();
        $user_session->id = $user->id;
        $user_session->username = $user->username;

        $user_session->startSession();
        header("Location: dashboard.php");
    }
    public static function register(
        string $username,
        string $password,
        string $email,
        string $confirmPassword,
        string &$usernameError,
        string &$passwordError,
        string &$emailError,
        string &$confirmPassError,
    ): bool {
        $usernameError = Validator::valid_username($username)->getError();
        $passwordError = Validator::valid_password($password)->getError();
        $emailError = Validator::valid_email($email)->getError();
        if (!empty($usernameError) || !empty($passwordError) || !empty($emailError)) {
            return false;
        }
        $confirmPassError = Validator::isFilled($confirmPassword, "Confirm Password")->getError();

        if (!empty($confirmPassError)) {
            return false;
        }
        if ($password != $confirmPassword) {
            $confirmPassError = "Passowrd must match!";
            return false;
        }
        $found_acc = false;
        if (User::find('username', $username)->isOk) {
            $usernameError = "Username is already registered!";
            $found_acc = true;
        }
        if (User::find('email', $email)->isOk) {
            $emailError = "Email is already registered!";
            $found_acc = true;
        }
        if ($found_acc) {
            return false;
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
        echo "Username: $username | Password: $password | email: $email";
        $user = new User();
        $user->setUser($username, $password, $email);

        $res = $user->save();
        if (!$res) {
            $usernameError = "An error occoured while saving your data! Please try again.";
            return false;
        }
        $user->id = (int)DB::getInstance()->getConnection()->lastInsertId();
        $user->startSession();
        header("Location: dashboard.php");
        return true;
    }
    public function canChangeUsername(string $username, string &$userError): bool
    {
        $userError = Validator::valid_username($username)->getError();
        if ($username == $this->username) {
            return false;
        }
        if (!empty($userError)) {

            return false;
        }
        if (User::find('username', $username)->isOk) {
            $userError = "Username is already registered!";
            return false;
        }
        return true;
    }
    public function canChangePassword(string $oldPassword, string $newPassword, string &$passError): bool
    {
        $passError = Validator::valid_password($newPassword)->getError();
        $user = User::find('id', $this->id)->unwrap();
        if (!password_verify($oldPassword, $user->password)) {
            $passError = "Incorrect password!";
            return false;
        }
        if (!empty($passError)) {
            return false;
        }
        if ($newPassword == $oldPassword) {
            $passError = "New password must be different from old password!";
            return false;
        }
        return true;
    }
    public function canChangeEmail(string $email, string &$emailError): bool
    {
        $emailError = Validator::valid_email($email)->getError();
        if ($email == $this->email) {
            return false;
        }
        if (!empty($emailError)) {
            return false;
        }
        if (User::find('email', $email)->isOk) {
            $emailError = "Email is already registered!";
            return false;
        }
        return true;
    }
    public function updateProfile(string $username, string $oldPassword, string $newPassword, string $email, string &$userError, string &$passError, string &$emailError): bool
    {
        $success = false;

        if ($this->canChangeEmail($email, $emailError) == true) {
            $this->email = $email;
            $success = true;
        }
        if ($this->canChangeUsername($username, $userError) == true) {
            $this->username = $username;
            $success = true;
        }
        if ($this->canChangePassword($oldPassword, $newPassword, $passError) == true) {
            $this->password = password_hash($newPassword, PASSWORD_DEFAULT);
            $success = true;
        }

        if (!$success) {
            return false;
        }

        if (!$this->save()) {
            return false;
        }
        $this->startSession();
        return true;
    }
    public function logout()
    {
        if (!User::inSession()) {
            return;
        }
        session_unset();
        header("Location: index.php");
    }
}
class Post extends Model
{
    protected static string $table = 'items';
    public int $id;
    public int $user_id;
    public string $description;
    public string $title;
    public string $created_at;
    public string $uploaded_at;
    public function makePost(string $title, string $description)
    {
        $this->title = $title;
        $this->description = $description;
        $this->created_at = gmdate("Y-m-d H:i:s");
    }
    public function getFiles(): Result
    {
        $res = File::find_all('item_id', $this->id);
        if ($res->isOk) {
            return $res;
        } else {
            return Result::err("No files found for this post!");
        }
    }
    public function removePost(): Result
    {
        $res = $this->getFiles();
        if ($res->isOk) {
            foreach ($res->unwrap() as $file) {
                $file->removeFile();
            }
        }
        $this->delete("id", $this->id);
        return Result::ok();
    }
    public function editItem() {}
    public function getItem() {}
    public function uploadPost(array $files, string &$overallError, User $user)
    {

        foreach ($files as $tempFile) {
            if ($tempFile instanceof File) {
            } else {
                $overallError = "The instance is not a file!";
                return;
            }
        }
        $db = DB::getInstance()->getConnection();
        $db->beginTransaction();

        $this->uploaded_at = gmdate("Y-m-d H:i:s");
        $this->user_id = $user->id;



        $res = tryFail(function () use ($files,  $user, $db) {

            $res = $this->save();
            $item_id = (int) $db->lastInsertId();
            if ($res == false) {
                $db->rollBack();
                $overallError = "Failed to upload your post!, please try again later";
                throw new Exception($overallError);
            }
            foreach ($files as $tempFile) {
                if ($tempFile instanceof File) {

                    $overallError =  $tempFile->uploadFile($user, $item_id)->getError();
                    if (!empty($overallError)) {
                        $db->rollBack();
                        throw new Exception($overallError);
                    }
                }
            }
        });
        if (!$res->isOk) {
            $overallError = $res->getError();
            $db->rollBack();
            return;
        }

        $db->commit();
    }
}

class File extends Model
{
    protected static string $table = 'files';
    public static function getTargetDir(): string
    {
        return "uploads/";
    }
    public static function maxSize(): int
    {
        return 2097152;
    }
    public int $id;
    public int $item_id;
    public string $filename;
    public string $filepath;
    public string $filetype;
    public int $filesize;
    public string $uploaded_at;
    public static function createFile(string $file_name, mixed $type, int $error, int $filesize, string $temp_file_path, User $user): Result
    {
        if ($error != 0) {
            return Result::err("Error in preparing file!");
        }

        if ($filesize > File::maxSize()) {
            return Result::err("File can not be over " . (File::maxSize() / (1024 * 1024)) . " MB long!");
        }
        $file = new File();
        $file->filename = $file_name;
        $file->filetype = $type;
        $file->filepath = $temp_file_path;
        return Result::ok($file);
    }
    public function removeFile(): Result
    {
        if (!Validator::isFilled($this, "File to remove")) {
            return Result::err("Please instantiate first!");
        }
        $this->delete("filepath", $this->filepath);
        unlink($this->filepath);
        return Result::ok();
    }
    public function uploadFile(User $user, int $item_id): Result
    {
        $userNotExist = Validator::isFilled($user, "user")->getError();
        if (!empty($userNotExist)) {
            return Result::err($userNotExist);
        }
        $filedir = File::getTargetDir() . $user->id . "/" . $item_id . "/" . $this->filename;
        $targetDir = dirname($filedir);
        $temp_path = $this->filepath;
        $this->filepath = $filedir;
        $this->item_id = $item_id;
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0777, true)) {
                return Result::err("Failed to create directory for user files!");
            }
        }
        if (file_exists($filedir)) {
            return Result::err("File already exists: " . htmlspecialchars($this->filename));
        }
        $this->uploaded_at = gmdate("Y-m-d H:i:s");
        if (!$this->save()) {
            return Result::err("Fail to save file info to the database");
        }
        $filename = $this->filename;
        $filepath = $this->filepath;
        if (move_uploaded_file($temp_path,  $filedir)) {
        } else {
            return Result::err("Failed to upload file!");
        }
        return Result::ok();
    }
}
