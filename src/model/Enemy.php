<?php
class Enemy {
    protected $id;
    protected $name;
    protected $description;
    protected $isBoss;
    protected $health;
    protected $strength;
    protected $defense;
    protected $image;
    protected $db;

    public function __construct($db) {
        if (!$db instanceof PDO) {
            throw new InvalidArgumentException("Conexión a la base de datos inválida.");
        }
        $this->db = $db;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getIsBoss() {
        return $this->isBoss;
    }

    public function setIsBoss($isBoss) {
        $this->isBoss = $isBoss;
        return $this;
    }

    public function getHealth() {
        return $this->health;
    }

    public function setHealth($health) {
        $this->health = $health;
        return $this;
    }

    public function getStrength() {
        return $this->strength;
    }

    public function setStrength($strength) {
        $this->strength = $strength;
        return $this;
    }

    public function getDefense() {
        return $this->defense;
    }

    public function setDefense($defense) {
        $this->defense = $defense;
        return $this;
    }

    public function save() {
        $stmt = $this->db->prepare("INSERT INTO enemies (name, description, isBoss, health, strength, defense) VALUES (:name, :description, :isBoss, :health, :strength, :defense)");
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':description', $this->description);
        $stmt->bindValue(':isBoss', $this->isBoss);
        $stmt->bindValue(':health', $this->health);
        $stmt->bindValue(':strength', $this->strength);
        $stmt->bindValue(':defense', $this->defense);
        return $stmt->execute();
    }
}
