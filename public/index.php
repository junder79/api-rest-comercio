<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/api-rest/public");


require_once('../src/config/conexion.php');



/* Rutas de peticiones */

$app->get('/productos', function (Request $request, Response $response) {
    $sql = "SELECT id,category,discount,name,price,url_image FROM product";
    try {
        $db = new db();
        $db = $db->conexionDB();
        /* Ejecutar la QUERY */
        $resultado = $db->query($sql);
        /* Cuenta la cantidad de filas, en caso de haber mayor a 0, hará un fetch y retornará un objeto json */
        if ($resultado->rowCount() > 0) {
            $vehiculos = $resultado->fetchAll(PDO::FETCH_OBJ);

            $response->getBody()->write(json_encode($vehiculos));
        } else {
            $response->getBody()->write(json_encode("No hay data"));
        }


        return $response;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e . '}';
    }
});

$app->get('/categorias', function (Request $request, Response $response) {

    $sql = "SELECT id,name  FROM category";
    try {
        $db = new db();
        $db = $db->conexionDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $vehiculos = $resultado->fetchAll(PDO::FETCH_OBJ);

            $response->getBody()->write(json_encode($vehiculos));
        } else {
            $response->getBody()->write(json_encode("No hay data"));
        }


        return $response;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e . '}';
    }
});


/* Ruta de peticion GET para traer los productos de dicha categorias, entregando por paràmetro, el id de categoria */

$app->get('/filtradoCategorias/{idCategoria}', function (Request $request, Response $response, array $args) {
    $idCategoria =  $args['idCategoria'];
    $sql = "SELECT id,category,discount,name,price,url_image FROM product WHERE category = $idCategoria";
    try {
        $db = new db();
        $db = $db->conexionDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $vehiculos = $resultado->fetchAll(PDO::FETCH_OBJ);

            $response->getBody()->write(json_encode($vehiculos));
        } else {
            $response->getBody()->write(json_encode("No hay data"));
        }


        return $response;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e . '}';
    }
});

$app->get('/buscar/{busqueda}', function (Request $request, Response $response, array $args) {
    $busqueda =  $args['busqueda'];
    $sql = "SELECT id,category,discount,name,price,url_image FROM product WHERE name LIKE '%$busqueda%'";
    try {
        $db = new db();
        $db = $db->conexionDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $vehiculos = $resultado->fetchAll(PDO::FETCH_OBJ);

            $response->getBody()->write(json_encode($vehiculos));
        } else {
            $response->getBody()->write(json_encode(""));
        }


        return $response;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e . '}';
    }
});

$app->run();
