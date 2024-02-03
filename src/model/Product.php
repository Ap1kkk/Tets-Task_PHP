<?php
    class Product {
        public ?int $id;
        public string $name;
        public string $description;
        public int $priceForJuridical;
        public int $priceForPhysical;

        public function __construct(string $name, string $description, int $priceForJuridical, int $priceForPhysical, ?int $id = null) {
            $this->id = $id;
            $this->name = $name;
            $this->description = $description;
            $this->priceForJuridical = $priceForJuridical;
            $this->priceForPhysical = $priceForPhysical;
        }
    }
?>