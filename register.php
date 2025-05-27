<?php

    header('Content-Type: application/json');

    require_once './db/Db_connect.php';
    
    // If connection fails, a JSON error will be returned and script will exit.
    $db = new DbConnect();
    $pdo = $db->connect();
     
    // Initialize response array
    $response = [
        'success' => false,
        'message' => '',
        'errors' => []
    ];

    if (!$pdo) {
        http_response_code(503); // Service Unavailable
        $response['errors']['general'] = "Service temporarily unavailable. Please try again later.";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $account_type = filter_input(INPUT_POST, "account_type", FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $full_name = filter_input(INPUT_POST, "full_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $company_name = filter_input(INPUT_POST, "company_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $contact_title = filter_input(INPUT_POST, "contact_title", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST["password"] ?? '';
        $repeat_password = filter_input(INPUT_POST, "repeat_password", FILTER_SANITIZE_SPECIAL_CHARS);
        $phone = htmlspecialchars(filter_input(INPUT_POST, "full_phone"));


        // Normalize lower and upper cases
        $account_type = ucwords(strtolower(trim($account_type)));
        $username = ucwords(strtolower(trim($username)));
        $full_name = ucwords(strtolower(trim($full_name)));
        $contact_title = ucwords(strtolower(trim($contact_title)));
        $company_name = ucwords(strtolower(trim($company_name)));
        $email = strtolower(trim($email));

        // ------ Error checking for empty fields --------
        $required = [
            'account_type' => $account_type,
            'username' => $username,
            'full_name' => $full_name,
            'email' => $email,
            'password' => $password,
            'repeat_password' => $repeat_password,
            'phone' => $phone
        ];

        foreach ($required as $field => $value) {
            if (empty($value)) {
                $response['errors'][$field] = "This field is required";                
            }
        }

        // ------ Validate parameters -----------

        /* account type */
        if ($account_type != "Individual" && $account_type != "Company") {
            $response['errors']['general'] = "Invalid account type";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT account_type_id FROM account_types WHERE account_description = ?");
                $stmt->execute([$account_type]);
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);  
                    $account_type = $row['account_type_id'];    
                } else {
                    $response['errors']['general'] = "Account type not found.";
                }

            } catch (PDOException $e) {   
                error_log("PDO error when reading accounts: " . $e->getMessage());                
                $response['errors']['general'] = "Error with the account type";
            }
        }

        /* password  */
        if (strlen($password) < 8) {
            $response['errors']['password'] = "Password must be at least 8 characters";
        }
         elseif ( !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
            $response['errors']['password'] = "Password must meet the requirements";
        }

        if ($password !== $repeat_password) {
            $response['errors']['repeat_password'] = "Passwords do not match";
        }

        // Username - Check if username already exists   
        if (strlen($username) < 3) {
            $response['errors']['username'] = "Username must be at least 3 characters";
        }
            // Username must only contain ASCII letters, digits, underscores, and hyphens (no accents or ñ)
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
            $response['errors']['username'] = "Please enter a valid username.";
        }

        try {
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->rowCount() > 0) {
                $response['errors']['username'] = "Username already exists";
                $response['errors']['general'] = "Username already exists. Please use a different one";
            }
        } catch (PDOException $e) {
            $response['errors']['general'] = "Error accessing the Database";
        }        
        
        // Full name          
        if (!preg_match('/^([\p{L}][\p{L}\'\-]{1,} )+[\p{L}][\p{L}\'\-]{1,}$/u', $full_name)) {
            $response['errors']['full_name'] = "Please enter your full name";
        }

               
        /* email  */
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['errors']['email'] = "Please enter a valid email";
        }
            // Check if email already exists
        try {
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $response['errors']['email'] = "This user already exists";
                $response['errors']['general'] = "This user already exists";
            }
        } catch (PDOException $e) {
            $response['errors']['general'] = "System unavailable - Please try again later";
        }
            
        //  Validate Phone Number

            // Loads library for phone number validation
        if (!empty($phone)) {
            try {                
                $loaderPath = __DIR__ . '/libraries/libphonenumber-loader.php';                
                if (!file_exists($loaderPath)) {
                    throw new Exception('Loader not found at: ' . $loaderPath);
                }                
                require_once $loaderPath;                
                
                if (!class_exists('libphonenumber\PhoneNumberUtil') || 
                    !class_exists('libphonenumber\NumberParseException')) {
                    throw new Exception('Failed to load libphonenumber classes');
                }                
                
                try {
                    $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
                    $parsedNumber = $phoneUtil->parse($phone, null);
                    
                    if (!$phoneUtil->isValidNumber($parsedNumber)) {
                        $response['errors']['phone'] = "Please enter a valid phone number";
                    } else {
                        $validPhone = $phoneUtil->format($parsedNumber, \libphonenumber\PhoneNumberFormat::E164);                        
                    }                   
                    
                } catch (\libphonenumber\NumberParseException $e) {
                    $response['errors']['phone'] = "Please enter a valid phone number";
                }
                               
                
            } catch (Exception $e) {
                error_log("LIBPHONENUMBER ERROR: " . $e->getMessage());
                $response['errors']['phone'] = "Phone validation service unavailable";
                $response['errors']['general'] = "System unavailable - Please try again later";
                http_response_code(500);
                echo json_encode($response);
                exit;
            }
        }


        // If errors exist, return them and exit
        if (!empty($response['errors'])) {
            http_response_code(400); // Bad Request            
            echo json_encode($response);
            exit;
        }

        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Execute Query
        try {

            $pdo->beginTransaction();

            // Insert user 
            $stmt = $pdo->prepare("
                INSERT INTO users (
                    account_type, 
                    username, 
                    full_name,
                    email, 
                    password_hash, 
                    phone
                ) VALUES (?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $account_type,
                $username,
                $full_name,                
                $email,
                $password_hash,
                $validPhone ?? null
            ]);

            // If company name and contact title are provided, insert into user_details
            if (!empty($company_name) || !empty($contact_title)) {
                $userId = $pdo->lastInsertId();
                $stmt = $pdo->prepare("
                    INSERT INTO user_titles (user_id, title, company_name) 
                    VALUES (?, ?, ?)
                ");
                $stmt->execute([
                    $userId,                    
                    $contact_title,
                    $company_name
                ]);
            }

            $pdo->commit(); 
            $response['success'] = true;
            $response['message'] = "Registration successful!";
            http_response_code(201);

        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
            http_response_code(500);
            $response['errors']['general'] = "Registration failed. Please try again.";  

            // *************  ONLY FOR DEBUGGING *****************            
            // $response['errors']['general'] = "Error accessing database" . $e->getMessage();
            // *************************************************** 
        }
        
        echo json_encode($response);
        exit;
        
    } else {
        http_response_code(405);
        $response['errors']['general'] = "Method not allowed.";
        echo json_encode($response);
        exit;
    }

    ?>