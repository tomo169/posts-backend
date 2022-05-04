<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiete DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiete post object
    $post = new Post($db);

    // Post query
    $result = $post->read();

    // get row count
    $num = $result->rowCount();

    // Check if eny posts 
    if($num > 0) {
        // Post arry
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $post_item = array(
                'id' => $id,
                'author_name' => $author_name,
                'author_email' => $author_email,
                'post_heading' => $post_heading,
                'post_content' => $post_content,
                'post_category' => $post_category,
                'create_date' => $create_date
            );

            // Push 
            array_push($posts_arr['data'], $post_item);
        }

        // turn to JSON & output
        echo json_encode($posts_arr);
    } else {
        // No posts 
        echo json_encode(
            array('message' => 'No posts Found')
        );
    }