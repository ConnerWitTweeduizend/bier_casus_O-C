<?php
try {
    $user = 'root';
    $pass = '';
    $dbh = new PDO('mysql:host=localhost;dbname=beer-casus', $user, $pass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

function showBeerRatings($dbh, $userId) {
    $sql = 'SELECT b.id, b.name, b.brewer, br.rating, br.note
            FROM beers b
            LEFT JOIN beer_ratings br ON b.id = br.beer_id AND br.user_id = :userId';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($result);
}

// Simulating logged-in user with a user ID (you need to replace this with your authentication mechanism)
$loggedInUserId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

// If user ID is not provided, return an error message
if ($loggedInUserId === null) {
    echo json_encode(array('error' => 'User ID not provided'));
    exit;
}

echo showBeerRatings($dbh, $loggedInUserId);
?>
