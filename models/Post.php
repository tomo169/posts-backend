<?php
class Post {
    // DB staff
    private $conn;
    private $table = 'posts';

    // Post Properties
    public $id;
    public $author_name;
    public $author_email;
    public $post_heading;
    public $post_content;
    public $post_category;
    public $create_date;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get posts
    public function read() {
        // Create query
        $query = 'SELECT
        p.id,
        p.author_name,
        p.author_email,
        p.post_heading,
        p.post_content,
        p.post_category,
        p.create_date
        FROM 
        ' . $this->table . ' p';

        //Prepare statemant
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Create post
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table  . '
            SET
            author_name = :author_name,
            author_email = :author_email,
            post_heading = :post_heading,
            post_content = :post_content,
            post_category = :post_category,
            create_date = :create_date';

        // Prepere statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->author_name = htmlspecialchars(strip_tags($this->author_name));
        $this->author_email = htmlspecialchars(strip_tags($this->author_email));
        $this->post_heading = htmlspecialchars(strip_tags($this->post_heading));
        $this->post_content = htmlspecialchars(strip_tags($this->post_content));
        $this->post_category = htmlspecialchars(strip_tags($this->post_category));
        $this->create_date = htmlspecialchars(strip_tags($this->create_date));

        // Bind data
        $stmt->bindParam(':author_name', $this->author_name);
        $stmt->bindParam(':author_email', $this->author_email);
        $stmt->bindParam(':post_heading', $this->post_heading);
        $stmt->bindParam(':post_content', $this->post_content);
        $stmt->bindParam(':post_category', $this->post_category);
        $stmt->bindParam(':create_date', $this->create_date);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if somethig go wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Update post
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table  . '
        SET
            author_name = :author_name,
            author_email = :author_email,
            post_heading = :post_heading,
            post_content = :post_content,
            post_category = :post_category,
            create_date = :create_date
        WHERE
            id = :id';

        // Prepere statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->author_name = htmlspecialchars(strip_tags($this->author_name));
        $this->author_email = htmlspecialchars(strip_tags($this->author_email));
        $this->post_heading = htmlspecialchars(strip_tags($this->post_heading));
        $this->post_content = htmlspecialchars(strip_tags($this->post_content));
        $this->post_category = htmlspecialchars(strip_tags($this->post_category));
        $this->create_date = htmlspecialchars(strip_tags($this->create_date));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':author_name', $this->author_name);
        $stmt->bindParam(':author_email', $this->author_email);
        $stmt->bindParam(':post_heading', $this->post_heading);
        $stmt->bindParam(':post_content', $this->post_content);
        $stmt->bindParam(':post_category', $this->post_category);
        $stmt->bindParam(':create_date', $this->create_date);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if somethig go wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete Post
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepere statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if somethig go wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
