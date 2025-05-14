<?php
class Result
{
    public $isOk;
    private mixed $value;
    private string $errorMessage;
    public function __construct($isOk, $value = null, $errorMessage = "")
    {
        $this->isOk = $isOk;
        $this->value = $value;
        $this->errorMessage = $errorMessage;
    }
    public static function ok($value = null)
    {
        return new self(true, $value, "");
    }
    public static function err($message = "Unspecified error!")
    {
        return new self(false, null, $message);
    }
    public function unwrap()
    {
        if (!$this->isOk) {
            throw new RuntimeException("Tried to unwrap an Err: {$this->errorMessage}");
        }
        return $this->value;
    }
    public function unwrapOr(mixed $fallback): mixed
    {
        return $this->isOk ? $this->value : $fallback;
    }
    public function getError()
    {
        return $this->errorMessage;
    }
}
function tryFail(callable $func): Result
{
    if (!is_callable($func)) {
        return Result::err("You passed non function!");
    }
    try {
        $res = $func();
        return Result::ok($res);
    } catch (Exception $e) {
        return Result::err("{$e->getMessage()}");
    }
}
class Validator
{
    public static function isFilled($var, string $varname = "Unknown"): Result
    {
        if (!isset($var)) {
            return Result::err("Error! {$varname} isn't set!");
        }
        if (empty($var)) {
            return Result::err("{$varname} is empty");
        }
        return Result::ok($var);
    }

    public static function valid_username(string $username): Result
    {
        $is_filled = Validator::isFilled($username, "Username");
        if (!$is_filled->isOk) {
            return $is_filled;
        }
        $min_len = 5;
        $max_len = 40;
        if (strlen($username) < $min_len) {
            return Result::err("Username can't be less than {$min_len} characters!");
        }
        if (strlen($username) > $max_len) {
            return Result::err("Username can't be more than {$max_len} characters!");
        }

        if (preg_match("/^[a-zA-Z]+$/", $username) == 0) {
            return Result::err("Username can only contain letters");
        }
        return Result::ok($username);
    }

    public static function valid_password(string $password): Result
    {
        $is_filled = Validator::isFilled($password, "Password");
        if (!$is_filled->isOk) {
            return $is_filled;
        }
        $min_len = 8;
        if (strlen($password) < $min_len) {
            return Result::err("Password must have at least {$min_len} characters");
        }
        if (preg_match("/[A-Z]/", $password) == 0) {
            return Result::err("Password must contain capital letter");
        }
        if (preg_match("/[a-z]/", $password) == 0) {
            return Result::err("Password must contain small letters");
        }
        if (preg_match("/[0-9]/", $password) == 0) {
            return Result::err("Password must contain numbers");
        }
        // if (preg_match("/[^\w\s]/", $password) == 0) {
            // return Result::err("Password must contain special characters");
        // }
        return Result::ok($password);
    }

    public static function valid_email(string $email): Result
    {
        $is_filled = Validator::isFilled($email, "Email");
        if (!$is_filled->isOk) {
            return $is_filled;
        }
        $max_len = 40;
        if (strlen($email) > $max_len) {
            return Result::err("Email can't be more than {$max_len} characters!");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return Result::err("Invalid email format");
        }
        return Result::ok($email);
    }
}
