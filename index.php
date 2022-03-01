<?php 
require('vendor/autoload.php');

use Popcorn\Pop;

$app = new Pop();

// Home page: http://localhost:8000/
$app->get('/', function() {
    http_response_code( 400 );
    echo 'Hello World!';
});

// Add a recipe: POST http://localhost:8000/recipes
$app->post('/recipes', function() {
    $json = file_get_contents("php://input");
    http_response_code( 200 );
    $contents = json_decode($json, true);
    $recipe = $contents["recipe"];
    $now = new DateTime();
    $formatted = $now->format('Y-m-d H:i:s');
    $recipe['created_at'] = $formatted;
    $recipe['updated_at'] = $formatted;
    $message = "Recipe successfully created!";

    $params = [
        "message"=> $message,
        "recipe"=> $recipe
    ];

    echo json_encode($params);
})

// Get all recipes : GET http://localhost:8000/recipes
$app->get('/recipes', function() {
    header('Access-Control-Allow-Headers: Origin, Content-Type');
    http_response_code( 200 );
    $params = [
        "recipes"=> [
            [
                "id"=> 1,
                "title"=> "チキンカレー",
                "making_time"=> "45分",
                "serves"=> "4人",
                "ingredients"=> "玉ねぎ,肉,スパイス",
                "cost"=> "1000"
            ],
            [
                "id"=> 2,
                "title"=> "オムライス",
                "making_time"=> "30分",
                "serves"=> "2人",
                "ingredients"=> "玉ねぎ,卵,スパイス,醤油",
                "cost"=> "700"
            ],
            [
                "id"=> 3,
                "title"=> "トマトスープ",
                "making_time"=> "15分",
                "serves"=> "5人",
                "ingredients"=> "玉ねぎ, トマト, スパイス, 水",
                "cost"=> "700"
            ]
        ]
    ];
    echo json_encode($params);
});

// Get recipe by id: GET http://localhost:8000/recipes/{id}
$app->get('/recipes/:id', function($id) {
    header('Access-Control-Allow-Headers: Origin, Content-Type');
    http_response_code( 200 );
    $message = "recipe details by id";
    $params = array();

    if($id=='1') {
        $params = [
            "message"=> $message,
            "recipe"=> [
                "id"=> $id,
                "title"=> "チキンカレー",
                "making_time"=> "45分",
                "serves"=> "4人",
                "ingredients"=> "玉ねぎ,肉,スパイス",
                "cost"=> "1000"
            ]
        ];
    } elseif($id=='2') {
        $params = [
            "message"=> $message,
            "recipe"=> [
                "id"=> $id,
                "title"=> "オムライス",
                "making_time"=> "30分",
                "serves"=> "2人",
                "ingredients"=> "玉ねぎ,卵,スパイス,醤油",
                "cost"=> "700"
            ]
        ];
    } elseif($id=='3') {
        $params = [
            "message"=> $message,
            "recipe"=> [
                "id"=> $id,
                "title"=> "トマトスープ",
                "making_time"=> "15分",
                "serves"=> "5人",
                "ingredients"=> "玉ねぎ, トマト, スパイス, 水",
                "cost"=> "700"
            ]
        ];
    }
    echo json_encode($params);
});

$app->delete('/recipes/:id', function($id) {
    header('Access-Control-Allow-Headers: Origin, Content-Type');
    http_response_code( 200 );
    $message = "Recipe successfully removed!";
    $params = [
        "message"=> $message
    ];
    echo json_encode($params);
}

// Wildcard route to handle errors
$app->get('*', function() {
    http_response_code( 404 );
    echo 'Invalid Request.';
});

// Post route to process an auth request
// $app->post('/auth', function() {
//     if ($_SERVER['HTTP_AUTHORIZATION'] == 'my-token') {
//         echo 'Auth successful';
//     } else {
//         echo 'Auth failed';
//     }
// });

$app->run();