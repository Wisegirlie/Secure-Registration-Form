<?php

    // Read .env file        
    $envPath = dirname(__DIR__) . '/.env';

    if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue; // skip comments
            list($name, $value) = explode('=', $line, 2);
            putenv(trim($name) . '=' . trim($value));
        }
    } else {
        error_log(".env file not found at: $envPath");
        // Optionally throw an exception or halt
        // throw new Exception("Environment configuration missing");
    }    

    // ***********************************************************
    // Connection to the database  ***  MSQLI ONLY ****
    // ***********************************************************
    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // report errors as exceptions

    // $db_server = getenv('DB_HOST');
    // $db_username = getenv('DB_USER');
    // $db_password = getenv('DB_PASS');
    // $db_name = getenv('DB_NAME');

    // try {
    //     $connection = new mysqli($db_server, $db_username, $db_password, $db_database);                
    //     $connection->set_charset("utf8mb4"); //  Prevents charset-based injection
    // } catch (mysqli_sql_exception $e) {  
    //     http_response_code(503); // Service Unavailable
    //     echo json_encode([
    //         "success" => false,
    //         'error' => 'Service temporarily unavailable. Please try again later.'
    //     ]);
    //     exit;
    // }
    // ***********************************************************

    // For improved security and flexibitlity use PDO instead of MySQLI and move it to a class

    class DbConnect {
        private string $host;
        private string $user;
        private string $pass;
        private string $dbname;
        private int $port;
     
        public function __construct()
        {
            $this->host = getenv('DB_HOST');
            $this->user = getenv('DB_USER');
            $this->pass = getenv('DB_PASS');
            $this->dbname = getenv('DB_NAME');
            $this->port = (int) getenv('DB_PORT');             
        }

        public function connect(string $dbname = '') : PDO {
            $this->dbname = $dbname ?: getenv('DB_NAME'); // If no dbname is passed, use default from .env
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";            
            try {
                $conn = new PDO($dsn, $this->user, $this->pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // throw exceptions on errors
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false, 
                ]);
                return $conn; 
            } catch (PDOException $e) {
                http_response_code(503); // Service Unavailable
                header('Content-Type: application/json');
                
                echo json_encode([
                    "success" => false,
                    "error" => "Service temporarily unavailable. Please try again later."
                ]);

                // *************  ONLY FOR DEBUGGING *****************
                // echo json_encode([
                //     "success" => false,
                //     "error" => "Database connection failed: " . $e->getMessage()
                // ]);
                // *************************************************** 


                error_log("Database connection error: " . $e->getMessage());                
                exit;
            }
        }
    }

?>
