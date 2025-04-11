<?php
class Database {
    private $host = "localhost";  // Hôte de la base de données
    private $db_name = "ecommerce";       // Nom de la base de données
    private $username = "root";      // Nom d'utilisateur
    private $password = "saif";      // Mot de passe
       // Port (par défaut PostgreSQL utilise 5432)
    public $conn;                // Instance de connexion PDO

    public function getConnection() {
        $this->conn = null;

        try {
            // Construire le DSN pour PostgreSQL avec le port
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            // Définir le mode de gestion des erreurs de PDO
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            // En cas d'erreur de connexion, afficher le message d'erreur
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
