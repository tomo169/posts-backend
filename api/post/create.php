<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, X-Requested-Width');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instatiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiete blog post object
    $post = new Post($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $post->author_name = $data->author_name;
    $post->author_email = $data->author_email;
    $post->post_heading = $data->post_heading;
    $post->post_content = $data->post_content;
    $post->post_category = $data->post_category;
    $post->create_date = $data->create_date;

    // Create post
    if($post->create()) {
        echo json_encode(
            array('message' => 'Post Created')
        );
    } else {
        echo json_encode(
            array('message' => 'Post Not Created')
        );
    }