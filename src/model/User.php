<?php
    class RoleEnum {
        const USER = 'user';
        const ADMIN = 'admin';

        public static function fromString(string $role): string {
            switch ($role) {
                case self::USER:
                case self::ADMIN:
                    return $role;
                default:
                    throw new InvalidArgumentException("Invalid role: $role");
            }
        }
    }

    class StatusEnum {
        const JURIDICAL = 'juridical';
        const PHYSICAL = 'physical';
    
        public static function fromString(string $status): string {
            switch ($status) {
                case self::JURIDICAL:
                case self::PHYSICAL:
                    return $status;
                default:
                    throw new InvalidArgumentException("Invalid status: $status");
            }
        }
    }

    class User {
        public ?int $id;
        public string $role;
        public string $fio;
        public string $status;
        public string $email;
        public string $phone;
        public string $city;
        public string $street;
        public string $house;
        public string $flat;
        public string $login;
        public string $password;

        public function __construct(string $role, string $fio, string $status, string $email, string $phone, string $city, 
                                    string $street, string $house, string $flat, string $login, string $password, ?int $id = null) {
            $this->id = $id;
            $this->role = $role;
            $this->fio = $fio;
            $this->status = $status;
            $this->email = $email;
            $this->phone = $phone;
            $this->city = $city;
            $this->street = $street;
            $this->house = $house;
            $this->flat = $flat;
            $this->login = $login;
            $this->password = $password;
        }

        public function getFullAddress() {
            return $this->city.', '.$this->street.', '.$this->house.', '.$this->flat;
        }
    }

?>
