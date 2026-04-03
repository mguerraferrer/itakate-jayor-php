<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Service class for user-related database operations
 */
class UserService extends BaseDAO {
    public function __construct() {
        parent::__construct();
        $this->table = 'users';
    }

    /**
     * Verify user credentials and return user data if valid
     * 
     * @param string $email User email
     * @param string $password User password
     * @return array|bool User data if valid, false otherwise
     */
    public function verifyCredentials(string $email, string $password): bool|array {
        $queryData = new QueryData(conditions: ['email' => $email]);
        $user = $this->findOne($queryData);
        
        if (empty($user)) {
            return false;
        }
        
        $userId = $user['id'];        
        $isActive = $user['active'];

        // If the user is inactive, return false immediately
        if (!$isActive) {
            return false; // User is inactive
        }

        if (password_verify($password, $user['password'])) {            
            // Update last_access
            $updateData = new QueryUpdateData(
                data: [
                    'last_access' => date('Y-m-d H:i:s')
                ],
                conditions: ['id' => $userId]
            );
            parent::update($updateData);
            return $user;
        }

        return false;
    }    
}