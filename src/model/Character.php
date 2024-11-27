<?php
class Character{
    protected $id;
    protected $name;
    protected $description;
    protected $health;
    protected $strength;
    protected $defense;
    protected $image;
    protected $db;

    public function __construct($db){
        $this->db=$db;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }

    public function getDefense()
    {
        return $this->defense;
    }

    public function setDefense($defense)
    {
        $this->defense = $defense;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
   
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function save(){
        $stmt = $this->db->prepare("INSERT INTO characters (name, description, health, strength, defense ) VALUES (:name, :description, :health, :strength, :defense)");
        $stmt->bindValue(':name', $this->getName());
        $stmt->bindValue(':description', $this->getDescription());
        $stmt->bindValue(':health', $this->getHealth());
        $stmt->bindValue(':strength', $this->getStrength());
        $stmt->bindValue(':defense', $this->getDefense());


        return $stmt->execute();
        
    }
}