<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ItemController extends Controller
{
    /**
     * @Route("/list")
     */
    public function listAction(Request $request) {

        // Versuche mit Datenbankserver zu verbinden
        $mysqli = new \mysqli("login-67.hoststar.ch","inf17s","jL6LCigmf!YB8Hh","inf17s");

        $mysqli->set_charset('utf8');

        // Bei einem Fehler -> Fehlermeldung ausgeben
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }

        // Daten aus Datenbank laden
        $sql = "SELECT * FROM Joel_items";
        $result = $mysqli->query($sql);

        // Als Array auslesen
        $row = $result->fetch_all();

        return $this->render("item/list.html.php", ["items" => $row]);
    }
    /**
     * @Route("/add")
     */
    public function addAction(Request $request){
        $itemCount = $request ->get('count');
        $itemName = $request ->get('name');
        
        $itemCount = intval($itemCount);
        

        // Versuche mit Datenbankserver zu verbinden
        $mysqli = new \mysqli("login-67.hoststar.ch","inf17s","jL6LCigmf!YB8Hh","inf17s");

        $mysqli->set_charset('utf8');

        // Bei einem Fehler -> Fehlermeldung ausgeben
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }

        $statement = $mysqli->prepare("INSERT INTO Joel_items(amount, name) VALUES(?,?)");
        $statement->bind_param("is", $itemCount, $itemName);

        $statement->execute();

        return $this->redirect("/list");
        
        echo"Füge ". $itemCount . " " . $itemName . " hinzu.";
        die('in add action');
    }
}