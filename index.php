<?php
require_once '_connec.php';
$pdo = new \PDO(DSN, USER, PASS);

function test_input($data)
{
    $errors = [];
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if (!empty($data) || strlen($data) < 45) {
        return $data;
    } else {
        $errors[] = "Erreur sur votre insertion. l'input est vide ou la chaîne de charactère est trop longue";
    }
    return $data;
}

if (isset($_POST["submit"])) {


    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $firstname = test_input($firstname);
    $lastname = test_input($lastname);

    $queryInsert = "INSERT INTO friend(firstname, lastname) VALUES (:firstname, :lastname)";
    $stmt = $pdo->prepare($queryInsert);

    $stmt->bindValue(":firstname", $firstname, PDO::PARAM_STR);
    $stmt->bindValue(":lastname", $lastname, PDO::PARAM_STR);

    $stmt->execute();
    $friend = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $querySelectALl = "SELECT * FROM friend";
    $statement = $pdo->query($querySelectALl);
    $friends = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($friends as $friend) {
        echo $friend['firstname'] . ' ' . $friend['lastname'] . '<br>';
    }
}
?>

<form action="index.php" method="post">
    <div><label for="firstname">Firstname: </label><input type="text" id="firstname" name="firstname" required></div>
    <div><label for="lastname">Lastname: </label><input type="text" id="lastname" name="lastname" required></div>
    <button type="submit" name="submit">Envoyer</button>
</form>
<div>


</div>