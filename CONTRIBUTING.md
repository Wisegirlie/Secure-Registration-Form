# 🌟 Contributing Guide

Contributions to improve this secure registration system are welcomed! 
Here’s how to get started.  


## 🛠️ How to Contribute

### 1. **Report Bugs**
- Check existing issues to avoid duplicates.
- Use the "Bug Report" template and provide:
    - Steps to reproduce the issue
    - Expected vs. actual behavior
    - Screenshots or logs (if applicable)

### 2. **Suggest Enhancements**
- Open an issue using the "Feature Request" template.
- Clearly explain the benefit and impact on security or usability.

### 3. **Submit Code Changes**
1. **Fork** the repository.
2. **Create a feature branch:**
     ```sh
     git checkout -b feat/your-feature-name
     ```
3. **Commit your changes** using the following format:
     ```
     type(scope): brief description
     ```
     **Example:**
     ```
     feat(auth): add password strength meter
     ```
4. **Test your changes:**
     - Ensure compatibility with PHP 8.0+.
     - Verify there are no SQL injection or XSS vulnerabilities.

5. **Push and open a Pull Request (PR):**
     - Link your PR to an existing issue if applicable.
     - Describe your changes and tag relevant reviewers (e.g., @username).
     - Update `README.md` if your changes affect setup or usage.


## ✅ Good First Contributions
- Add a password strength meter for real-time feedback during registration.
- Improve frontend UX (animations, design).
- Improve form validation messages (frontend/backend)
- Write unit tests for PHP functions
- Integrate Google reCAPTCHA or similar tools for enhanced bot protection.


## 📜 Code Standards
- **PHP:** Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards.
- **JavaScript:** Use ES6+ syntax.
- **CSS:** Prefer BEM naming convention.


## ❓ Questions?
Open a discussion in the Issues tab or reach out via the repository’s contact channels.


**Thank you!!!**
