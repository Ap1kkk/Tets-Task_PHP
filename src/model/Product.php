<?php
    class Product {
        public ?int $id;
        public string $name;
        public string $description;
        public int $priceForJuridical;
        public int $priceForPhysical;
        public $image;

        public function __construct(string $name, string $description, int $priceForJuridical, int $priceForPhysical, ?int $id = null, $image = null) {
            $this->id = $id;
            $this->name = $name;
            $this->description = $description;
            $this->priceForJuridical = $priceForJuridical;
            $this->priceForPhysical = $priceForPhysical;
            $this->image = $image;
        }
    }
?>