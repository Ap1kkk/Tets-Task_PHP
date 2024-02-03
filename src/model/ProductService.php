<?php
    require_once "Database.php";
    require_once "Product.php";

    class ProductService {
        private Database $db;

        public function __construct(?Database $database = null) {
            $this->db = isset($database) ? $database: new Database() ;
        }

        public function saveProduct(Product $product): ?Product {
            try {
                $query = "INSERT INTO products (name, description, priceForJuridical, priceForPhysical)
                        VALUES (:name, :description, :priceForJuridical, :priceForPhysical)";

                $params = [
                    ':name' => $product->name,
                    ':description' => $product->description,
                    ':priceForJuridical' => $product->priceForJuridical,
                    ':priceForPhysical' => $product->priceForPhysical,
                ];

                $this->db->query($query, $params);
                $product->id = $this->db->lastInsertId();

                return $product;
            } catch (Exception $e) {
                return null;
            }
        }

        public function getAllProducts(): array {
            try {
                $query = "SELECT * FROM products";
                $result = $this->db->query($query, fetchType: FETCH_TYPE::ALL);

                $products = [];
                foreach ($result as $row) {
                    $product = new Product(
                        $row['name'],
                        $row['description'],
                        $row['priceForJuridical'],
                        $row['priceForPhysical'],
                        $row['id']
                    );
                    $products[] = $product;
                }

                return $products;
            } catch (Exception $e) {
                return [];
            }
        }
    }
?>