<!-- Invitation
Bonjour Golove Etienne,

voici la tâche de test:

Ecrire une classe pour travailler avec l'API https://jsonplaceholder.typicode.com

Faire des méthodes pour obtenir les utilisateurs, leurs messages et emplois

Ajouter une méthode pour travailler avec un poste spécifique (ajouter / modifier / supprimer)

Résultat verser sur GitHub avec des exemples d'appels de classe
Version PHP 7.*

L'utilisation de Composer est autorisée

délai d'exécution illimité

Respectueusement,
SWC POLIS
polis812.ru -->
<?php

/**
 * class for CRUD implementation
 */
class JSONPlaceholderUserAPI
{


    //private $baseUrl = 'https://jsonplaceholder.typicode.com/users';
    // url for the web server
    private $baseUrl = 'http://localhost:3000/users';

    /**
     * method for requesting with @url{string} , @method and @data
     */
    private function makeRequest($url, $method, $data = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * get numeric inside the string url
     */
    public function get_numerics($str)
    {
        preg_match_all('/\/users\/(\d+)/', $str, $matches);
        var_dump('mach.....', $matches[1]);
        return $matches[1];
    }

    /**
     * get All Users informations
     */
    public function getUsers()
    {
        $response = $this->makeRequest($this->baseUrl, 'GET');
        return json_decode($response, true);
    }

    /**
     * get user with @userID{string}
     */
    public function getUser($userId)
    {
        $response = $this->makeRequest($this->baseUrl . '/' . $userId, 'GET');
        return json_decode($response, true);
    }

    /**
     * create a new @userData{Object}
     */
    public function createUser($userData)
    {
        $userDataJson = json_encode($userData);
        $response = $this->makeRequest($this->baseUrl, 'POST', $userDataJson);
        return json_decode($response, true);
    }

    /**
     * Update user information with @userId{int} and @userData{Array} 
     */
    public function updateUser($userId, $userData)
    {
        $userDataJson = json_encode($userData);
        $url = $this->baseUrl . '/' . $userId;
        $response = $this->makeRequest($url, 'PUT', $userDataJson);
        return json_decode($response, true);
    }

    /**
     * delete User with @userId{string}
     */
    public function deleteUser($userId)
    {
        $url = $this->baseUrl . '/' . $userId;
        $response = $this->makeRequest($url, 'DELETE');
        return json_decode($response, true);
    }
}

// create the instance of the class
$jsonPlaceholderUserAPI = new JSONPlaceholderUserAPI();
$userId = $jsonPlaceholderUserAPI->get_numerics($_SERVER['REQUEST_URI']);

// check if we are some get request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // get data for a specific users with id  and else send the data for all users
    if (preg_match("/^\/users\/\d+$/", $_SERVER['REQUEST_URI'])) {

        // run the method to get user info
        $user = $jsonPlaceholderUserAPI->getUser($userId[0]);
        var_dump($user);
    } else {
        $users = $jsonPlaceholderUserAPI->getUsers();
        var_dump($users);
    }

    // POST REQUEST 
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump("userId");

    $requestBody = file_get_contents('php://input');
    $reqObj = json_decode($requestBody);

    // Create (Insert)
    $newUser = [
        "id" => $reqObj->id,
        "name" => $reqObj->name,
        "username" => $reqObj->username
    ];
    $createdUser = $jsonPlaceholderUserAPI->createUser($newUser);
    var_dump($newUser);

    // ...
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    // extract the id to the request
    // $string = $_SERVER['REQUEST_URI'];
    // $pattern = '/\/users\/(\d+)/';
    // preg_match($pattern, $string, $matches);

    if (isset($userId[0])) {
        $requestBody = file_get_contents('php://input');
        $reqObj = json_decode($requestBody);
        // Update    
        $updatedUserData = [
            "name" => $reqObj->name,
            "username" => $reqObj->username
        ];
        $updatedUser = $jsonPlaceholderUserAPI->updateUser($userId[0], $updatedUserData);
        var_dump($updatedUserData);
    } else {
        echo "Number not found in the string.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    // Delete 4 
    function checkelement(array $myarray, $userId)
    {
        foreach ($myarray as $element) {
            // var_dump('id ..',$element["id"], 'userID',intval($userId) );
            if ($element["id"] == intval($userId)) {
                $jsonPlaceholderUserAPI = new JSONPlaceholderUserAPI();
                $jsonPlaceholderUserAPI->deleteUser($userId);
                var_dump("user ", $userId, " deleting .");
            }
        }
    };

    checkelement($jsonPlaceholderUserAPI->getUsers(), $userId[0]);

    // ...
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['message' => 'Method not allowed']);
}



?>