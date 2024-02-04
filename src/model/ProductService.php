<?php
    require_once "Database.php";
    require_once "Product.php";

    class ProductService {
        private Database $db;

        public function __construct(?Database $database = null) {
            $this->db = isset($database) ? $database: new Database() ;
        }

        public function addProduct(Product $product): ?Product {
            try {
                $query = "INSERT INTO products (name, description, priceForJuridical, priceForPhysical, image)
                        VALUES (:name, :description, :priceForJuridical, :priceForPhysical, :image)";
    
                $params = [
                    ':name' => $product->name,
                    ':description' => $product->description,
                    ':priceForJuridical' => $product->priceForJuridical,
                    ':priceForPhysical' => $product->priceForPhysical,
                    ':image' => $product->image,
                ];
    
                $this->db->query($query, $params);
                $product->id = $this->db->lastInsertId();
    
                return $product;
            } catch (Exception $e) {
                return null;
            }
        }

        public function updateProduct(Product $product): bool {
            try {
                $query = "UPDATE products SET name = :name, description = :description, 
                          priceForJuridical = :priceForJuridical, priceForPhysical = :priceForPhysical, image = :image 
                          WHERE id = :id";
    
                $params = [
                    ':id' => $product->id,
                    ':name' => $product->name,
                    ':description' => $product->description,
                    ':priceForJuridical' => $product->priceForJuridical,
                    ':priceForPhysical' => $product->priceForPhysical,
                    ':image' => $product->image,
                ];
    
                $this->db->query($query, $params);
    
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        public function deleteProduct(int $productId): bool {
            try {
                $imagePath = $this->getProductImage($productId);
        
                $query = "DELETE FROM products WHERE id = :id";
                $params = [':id' => $productId];
        
                $this->db->query($query, $params);

                if ($imagePath) {
                    unlink($imagePath);
                }
        
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        public function getProductImage($productId) {
            try {
                $query = "SELECT image FROM products WHERE id = ?";
                $result = $this->db->query($query, [$productId], fetchType: FETCH_TYPE::FIRST);
        
                if ($result && isset($result['image'])) {
                    return $result['image'];
                } else {
                    return null;
                }
            } catch (Exception $e) {
                return null;
            }
        }

        public function getProductById($productId): ?Product
        {
            try {
                $query = "SELECT * FROM products WHERE id = ?";
                $result = $this->db->query($query, [$productId], fetchType: FETCH_TYPE::FIRST);

                if ($result) {
                    $product = new Product(
                        $result['name'],
                        $result['description'],
                        $result['priceForJuridical'],
                        $result['priceForPhysical'],
                        $result['id'],
                        $result['image'],
                    );

                    return $product;
                } else {
                    return null;
                }
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
                        $row['id'],
                        $row['image'],
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