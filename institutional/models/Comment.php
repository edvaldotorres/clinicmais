<?php
class Comment
{
    private $conn;
    private $table = 'comments';

    public $post_id;
    public $author;
    public $content;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Função para criar um comentário
    public function create()
    {
        // Atualiza a consulta para incluir o campo created_at
        $query = "INSERT INTO " . $this->table . " (post_id, author, content, created_at) VALUES (:post_id, :author, :content, :created_at)";

        $stmt = $this->conn->prepare($query);

        // Limpa os dados
        $this->post_id = htmlspecialchars(strip_tags($this->post_id));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->content = htmlspecialchars(strip_tags($this->content));

        // Obtém a data e hora atuais para created_at
        $created_at = date('Y-m-d H:i:s');

        // Vincula os parâmetros
        $stmt->bindParam(':post_id', $this->post_id);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':created_at', $created_at);

        // Executa a query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Função para buscar comentários por post_id
    public function getCommentsByPostId($post_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE post_id = :post_id ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
