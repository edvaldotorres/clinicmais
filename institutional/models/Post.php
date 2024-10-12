<?php

class Post
{
    private $conn;
    private $table = 'posts';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para buscar posts com paginação e pesquisa
    public function getPaginatedPosts($limit, $offset, $search = '')
    {
        $query = "SELECT * FROM " . $this->table;

        // Se houver um termo de pesquisa, filtra pelo título ou conteúdo
        if (!empty($search)) {
            $query .= " WHERE title LIKE :search OR content LIKE :search";
        }

        $query .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($query);

        // Adiciona os parâmetros da pesquisa, limite e offset
        if (!empty($search)) {
            $searchParam = "%{$search}%";
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt;
    }

    // Método para contar o número total de posts (para paginação)
    public function countPosts($search = '')
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;

        // Se houver um termo de pesquisa, filtra pelo título ou conteúdo
        if (!empty($search)) {
            $query .= " WHERE title LIKE :search OR content LIKE :search";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($search)) {
            $searchParam = "%{$search}%";
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total'];
    }
}
