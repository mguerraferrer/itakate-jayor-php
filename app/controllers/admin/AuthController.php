<?php
session_start();

require_once __DIR__ . '/../../../autoload.php';

/**
 * Auth Controller
 */
class AuthController {
    private UserService $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    /**
     * Authenticate a user and start a session
     * 
     * @param string $email - user email
     * @param string $password - user password
     * @return bool True if login successful, false otherwise
     */
    public function login(string $email, string $password): bool {
        $user = $this->userService->verifyCredentials($email, $password);
        if ($user) {
            session_regenerate_id(true);  // Security against session fixation
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = 'ADMIN';
            $_SESSION['userSession'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
                'role' => 'ADMIN',
                'isAdmin' => true,
            ];
            $_SESSION['last_activity'] = time();  // For timeout
            return true;
        }
        return false;
    }

    /**
     * Logout user and destroy session
     */
    public function logout(): void {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * Check if a user is logged in
     * 
     * @return bool
     */
    public function isLoggedIn(): bool {
        if (isset($_SESSION['user_id'])) {
            // Check timeout (e.g., 30 min inactivity)
            if (time() - $_SESSION['last_activity'] > 1800) {
                $this->logout();
                return false;
            }
            $_SESSION['last_activity'] = time();  // Update activity
            return true;
        }
        return false;
    }

    /**
     * Get current logged in user data
     * 
     * @return array|null
     */
    public function getCurrentUser(): ?array {
        if ($this->isLoggedIn()) {
            $queryData = new QueryData(conditions: ['id' => $_SESSION['user_id']]);
            return $this->userService->findOne($queryData);
        }
        return null;
    }

    /**
     * Check if a user has an ADMIN role
     */
    public function isAdmin(): bool {
        return $this->isLoggedIn() && $_SESSION['user_role'] === 'ADMIN';
    }

    /**
     * Require a user to be logged in, optionally with specific role
     * 
     * @param string|null $requiredRole - required user role
     */
    public function requireLogin(string $requiredRole = null): void {
        if (!$this->isLoggedIn()) {
            header('Location: ../web/auth/login'); // Redirect to log in
            exit;
        }
        if ($requiredRole && $_SESSION['user_role'] !== $requiredRole) {
            die("Access denied.");
        }
    }
}