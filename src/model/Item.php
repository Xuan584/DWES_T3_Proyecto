<?php

class Item
{
    protected $id;
    protected $name;
    protected $description;
    protected $type;
    protected $effect;
    protected $img;
    protected $db;

    public function __construct($db){
        $this->db=$db;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getEffect()
    {
        return $this->effect;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setEffect($effect)
    {
        $this->effect = $effect;
    }

    public function save() {
        $stmt = $this->db->prepare("INSERT INTO items (name, description, type, effect) VALUES (:name, :description, :type, :effect)");
        $stmt->bindValue(':name', $this->getname());
        $stmt->bindValue(':description', $this->getDescription());
        $stmt->bindValue(':type', $this->getType());
        $stmt->bindValue(':effect', $this->getEffect());
        return $stmt->execute();
    }
}
