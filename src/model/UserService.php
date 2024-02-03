<?php
    require_once 'Database.php';
    require_once 'User.php';

    class UserService {
        private Database $db;

        public function __construct(?Database $database = null) {
            $this->db = isset($database) ? $database: new Database() ;
        }

        public function saveUser(User $user) {
            try {
                if (!$this->isEmailUnique($user->email, $user->id)) {  
                    return false;
                }

                $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);

                if ($user->id === null) {
                    $query = "INSERT INTO users (role, fio, status, email, phone, city, street, house, flat, login, password)
                              VALUES (:role, :fio, :status, :email, :phone, :city, :street, :house, :flat, :login, :password)";
                } else {
                    $query = "UPDATE users SET role = :role, fio = :fio, status = :status, email = :email, phone = :phone,
                                  city = :city, street = :street, house = :house, flat = :flat,
                                  login = :login, password = :password
                              WHERE id = :id";
                }

                $params = [
                    ':role' => $user->role,
                    ':fio' => $user->fio,
                    ':status' => $user->status,
                    ':email' => $user->email,
                    ':phone' => $user->phone,
                    ':city' => $user->city,
                    ':street' => $user->street,
                    ':house' => $user->house,
                    ':flat' => $user->flat,
                    ':login' => $user->login,
                    ':password' => $hashedPassword,
                ];
    
                if ($user->id !== null) {
                    $params[':id'] = $user->id;
                }
    
                $this->db->query($query, $params, FETCH_TYPE::FIRST);
    
                return true;
            } catch (Exception $e) {
                // Обработка ошибок
                return false;
            }
        }

        public function getUserByEmail(string $email) {
            try {
                $query = "SELECT * FROM users WHERE email = :email";
                $params = array(':email' => $email);
    
                $result = $this->db->query($query, $params, FETCH_TYPE::FIRST);
    
                if ($result) {
                    return $this->createUser($result);
                } else {
                    return null; 
                }
            } catch (Exception $e) {
                return null;
            }
        }
        
        public function getUserById(int $userId) {
            try {
                $query = "SELECT * FROM users WHERE id = :userId";
                $params = array(':userId' => $userId);
    
                $result = $this->db->query($query, $params, FETCH_TYPE::FIRST);
    
                if ($result) {
                    return $this->createUser($result);
                } else {
                    return null; 
                }
            } catch (Exception $e) {
                return null;
            }
        }
                
        public function isEmailUnique(string $email, ?int $userId = null): bool {
            $query = "SELECT COUNT(*) as count FROM users WHERE email = :email";
            $params = [':email' => $email];

            if ($userId !== null) {
                $query .= " AND id != :userId";
                $params[':userId'] = $userId;
            }
        
            $result = $this->db->query($query, $params);
        
            return ($result['count'] == 0);
        }

        public function getAllUsers(): array
        {
            try {
                $query = "SELECT * FROM users";
                $result = $this->db->query($query, [], FETCH_TYPE::ALL);

                $users = [];
                foreach ($result as $row) {
                    $user = $this->createUser($row);
                    $users[] = $user;
                }

                return $users;
            } catch (Exception $e) {
                return [];
            }
        }

        private function createUser($queryResult) : User {
            return new User(
                RoleEnum::fromString($queryResult['role']),
                $queryResult['fio'],
                StatusEnum::fromString($queryResult['status']),
                $queryResult['email'],
                $queryResult['phone'],
                $queryResult['city'],
                $queryResult['street'],
                $queryResult['house'],
                $queryResult['flat'],
                $queryResult['login'],
                $queryResult['password'],
                $queryResult['id'],
            );
        }
    }
?>