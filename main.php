<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db_config.php';  // Make sure the path is correct

// Display errors for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to MySQL using the constants from db_config.php
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// echo "Connected successfully!"; // Uncomment to test connection

class User {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    // Registration
    public function reg_user($fname, $lname, $email, $nic, $password, $address, $phoneno, $usertype) {
        $passwordEn = md5($password);
        $sql = "SELECT * FROM users WHERE email='$email' OR nic='$nic'";
        $check = $this->db->query($sql);
        if ($check->num_rows == 0) {
            $sqlIn = "INSERT INTO users (fName, lName, email, nic, password, address, phoneNo, userType) 
                      VALUES ('$fname', '$lname', '$email', '$nic', '$passwordEn', '$address', '$phoneno', '$usertype')";
            return $this->db->query($sqlIn);
        }
        return false;
    }

    // Login
    public function login($email, $password) {
        $passwordEn = md5($password);
        $sql = "SELECT userId, userType FROM users WHERE email='$email' AND password='$passwordEn'";
        $result = $this->db->query($sql);
        if ($result->num_rows == 1) {
            $user_data = $result->fetch_assoc();
            $_SESSION['login'] = true;
            $_SESSION['userId'] = $user_data['userId'];
            if ($user_data['userType'] == "Buyer") {
                header("Location: BuyersHome.php");
            } else if ($user_data['userType'] == "Saller") {
                header("Location: sellerHome.php");
            }
            exit;
        }
        echo "Wrong username or password";
        return false;
    }

    // Admin login
    public function Adminlogin($email, $password) {
        $passwordEn = md5($password);
        $sql = "SELECT adminId FROM admint WHERE emailadmin='$email' AND passwordadmin='$passwordEn'";
        $result = $this->db->query($sql);
        if ($result->num_rows == 1) {
            $user_data = $result->fetch_assoc();
            $_SESSION['login'] = true;
            $_SESSION['adminId'] = $user_data['adminId'];
            return true;
        }
        return false;
    }

    public function get_firstname($userid) {
        $sql = "SELECT fName FROM users WHERE userId=$userid";
        $result = $this->db->query($sql);
        $user_data = $result->fetch_assoc();
        echo $user_data['fName'];
    }

    public function get_email($adminid) {
        $sql = "SELECT emailadmin FROM admint WHERE adminId=$adminid";
        $result = $this->db->query($sql);
        $user_data = $result->fetch_assoc();
        echo $user_data['emailadmin'];
    }

    public function get_session() {
        return $_SESSION['login'] ?? false;
    }

    public function user_logout() {
        $_SESSION['login'] = false;
        session_destroy();
    }
}

// Initialize User object
$user = new User($mysqli);
?>
