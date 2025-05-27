# 🔒 Secure Registration System

A security-focused user registration system built with **PHP**, **MySQL**, **HTML5**, **CSS3**, and **JavaScript**, following best practices to prevent common vulnerabilities.  


## 🛠️ Tech Stack

![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?logo=php)  
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql)  
![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=white)  
![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)  
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=black) 



## ✨ Features

- User-friendly registration form
- Input validation (client-side and server-side)
- Easy to customize and integrate
- Enforces password strength requirements
- International phone number support
- Accessibility support
- Responsive design
- Normalized database structure
- Secure data storage following best database practices
- Pasword hashing and SQL injection prevention
- Modular code (easy to extend)
- Ready for deployment or extension



## 📋 Requirements

- **PHP** 8.0 or higher  
- **MySQL** 5.7 or higher (phpMyAdmin recommended)  
- For local development, use a compatible server environment such as **XAMPP**, **MAMP**, or similar.
- Web browser (Chrome, Firefox, Edge, etc.)

## ⚙️ Installation

1. Clone, fork, or download this repository.
2. Create the database and tables by importing the provided SQL file: `db/Db_creation.sql`
3. Create a `.env` file in the project root with your database credentials:

    ```env
    DB_HOST=localhost         # Database host (e.g., localhost)
    DB_USER=your_username     # Your database username
    DB_PASS=your_password     # Your database password
    DB_NAME=your_database     # Your database name
    DB_PORT=3306              # (Optional) Database port, default is 3306
    ```
4. Customize the system as needed for your project.  
5. Deploy to a PHP-enabled server with a configured database.



### 🛡️ Security Notes

Always use HTTPS in production.



## 📸 Screenshots

![Preview](/images/screenshot-01-resize.jpg)



## 🤝 Contributing

Contributions are welcome! 
Here’s how:

Fork the repository.
- Improve the code (e.g., add features, fix bugs, enhance security).
- Submit a Pull Request with a clear description.

If you have suggestions, bug fixes, unit tests, or improvements, feel free to open an issue or submit a pull request.



## 🔥 Contribution Ideas, Customizations and Additions

- Integrate Google reCAPTCHA or similar tools for enhanced bot protection.
- Redirect users to a confirmation, email activation/verification, or onboarding page after successful registration.
- Adapt the design and file structure to fit into larger or more complex web applications.
- Replace `intl-tel-input` with an alternative library for improved autofill and phone number handling.
- Add a password strength meter for real-time feedback during registration.
- Improve frontend UX (animations, design).
- Improve form validation messages (frontend/backend)
- Write unit tests for PHP functions



## Live Demo 

You can try the form in the following link:

[Live Demo](https://gabywaisman.com/portfolio/secure-registration-form/index.html){:target="_blank" rel="noopener"}


<a href="https://gabywaisman.com/portfolio/secure-registration-form/index.html" target="_blank" rel="noopener">Live Demo</a>


**Enjoy!**
