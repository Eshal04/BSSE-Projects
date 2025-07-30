<?php
class crud {
    private $db;

    // ✅ Constructor to assign connection
    public function __construct($conn){
        $this->db = $conn;
    }

    // ✅ Search by name using correct property $this->db
    public function searchProductsByName($searchTerm) {
        try {
            $sql = "SELECT * FROM product WHERE name LIKE :name";
            $stmt = $this->db->prepare($sql);  // ✅ Fixed here
            $stmt->bindValue(':name', '%' . $searchTerm . '%');
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // ✅ Get all products
    public function getProducts(){
        $sql = "SELECT * FROM product";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    // ✅ Add a product
    public function addProduct($name, $price, $desc, $img){
        $sql = "INSERT INTO product (name, price, `desc`, img) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $price, $desc, $img]);
    }

    // ✅ Get product by ID
    public function getProductById($id){
        $sql = "SELECT * FROM product WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Add to cart method
    public function addToCart($user_id, $product_id, $quantity) {
        $stmt = $this->db->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $check = $this->db->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
            $check->execute([$user_id, $product_id]);
            $exists = $check->fetch();

            if ($exists) {
                $update = $this->db->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
                $update->execute([$quantity, $user_id, $product_id]);
            } else {
                $insert = $this->db->prepare("INSERT INTO cart (user_id, product_id, price, img, `desc`, quantity) VALUES (?, ?, ?, ?, ?, ?)");
                $insert->execute([
                    $user_id,
                    $product_id,
                    $product['price'],
                    $product['img'],
                    $product['desc'],
                    $quantity
                ]);
            }
        }
    }
}
?>
