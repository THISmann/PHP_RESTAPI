<?php

// class BlogData
// {
//     public readonly string $title;

//     public readonly Status $status;

//     public function __construct(string $title, Status $status)
//     {
//         $this->title = $title;
//         $this->status = $status;
//     }
// }

class Fruit {
    // Properties
    public $name;
    public $color; 
    function __construct($name, $color){
        $this->name = $name;
        $this->color = $color;
    }

    // function __destruct(){
    //     echo "The fruit is {$this->name}.";
    // }
    /**
     * set name
     */
     function set_name($name){
        $this->name = $name;
    }

    function get_name(){
        return $this->name;
    }

    function set_color($color){
        $this->color = $color;
    }

    function get_color(){
        return $this->color;
    }

    protected function set_weight($n){
        $this->color = $n;
    }

    private function set_size($n){
        $this->weight = $n;
    }
    public function intro(){
        echo "The fruit is {$this->name} and the color is {$this->color}. ----";
    }
}

class Nicefruits extends Fruit{

    public $weight;
    public function __construct($name, $color, $weight) {
      $this->name = $name;
      $this->color = $color;
      $this->weight = $weight;
    }
    public function message(){
        echo "The fruit is nice.";
        $this->intro();
    }

    public function intro() {
        echo "The fruit is {$this->name}, the color is {$this->color}, and the weight is {$this->weight} gram.";
      }
}

// $apple = new Fruit('apple');
// $banana = new Fruit('banana');
// $apple->set_name('Apple');
// $apple->set_color('blue');
// $banana->set_name('Banana');
// $banana->set_color('yellow');

// echo $apple->get_name();
// echo $apple->get_color();

// echo" --- ";

// echo $banana->get_name();
// echo $banana->get_color();

// var_dump($apple instanceof Fruit);

$strawberry = new Nicefruits("fraise", "rouge","90");
$strawberry->intro();