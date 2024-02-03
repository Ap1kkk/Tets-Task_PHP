<?php

require_once "UserService.php";

class Authenticator {
    private UserService $userService;
    private ?User $currentUser; 

    public function __construct(?UserService $userService = null) {
        if($userService !== null)
            $this->userService = $userService;
        else
            $this->userService = new UserService;

        $this->currentUser = $this->getCurrentUserFromCookie();
    }

    public function registerUser(User $user) {
        return $this->userService->saveUser($user);
    }

    public function updateUser(User $user) {
        return $this->userService->saveUser($user);
    }

    public function loginUserByEmail($email, $password) {
        $user = $this->userService->getUserByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            $this->currentUser = $user;
            $this->setUserCookie($user->id);
            return true;
        }

        return false;
    }

    public function getCurrentUser() {
        return $this->currentUser;
    }

    public function logout() {
        $this->currentUser = null;
        $this->clearUserCookie();
    }

    private function setUserCookie($userId) {
        setcookie('user_id', $userId, 0, '/');
    }

    private function clearUserCookie() {
        setcookie('user_id', '', time() - 3600, '/');
    }

    private function getCurrentUserFromCookie() {
        if (isset($_COOKIE['user_id'])) {
            $userId = $_COOKIE['user_id'];
            return $this->userService->getUserById($userId);
        }

        return null;
    }
}

?>
