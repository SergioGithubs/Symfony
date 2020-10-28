<?php

namespace App\Controller;

use App\Repository\ProductosRepository;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CollaboratorController
 * @Route("/api/productos")
 */
class ProductosController extends AbstractFOSRestController
{
    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getProductos($id, ProductosRepository $ProductosRepository, SerializerInterface $serializer)
    {
        $producto = $ProductosRepository->find($id);
        $response = $producto != null ?
            [
                'code' => 200,
                // 'error' => $error,
                'data' => $producto,
            ] : [
                'code' => 404,
                'message' => 'Entity not found',
            ];
        return new Response($serializer->serialize($response, "json"), $status = $response["code"]);
    }

    /**
     * @Route("/precios/{precio1}-{precio2}", methods={"GET"})
     */
    public function getPrecios($precio1, $precio2, ProductosRepository $ProductosRepository, SerializerInterface $serializer)
    {
        // echo $precio1 . '/' . $precio2;exit;
        // $producto = $ProductosRepository->findBy(array("precio" => "11"));

        $query = $ProductosRepository->createQueryBuilder('p')
            ->where('p.precio >= :price AND p.precio <= :price2')
            ->setParameter('price', $precio1)
            ->setParameter('price2', $precio2)
            ->orderBy('p.precio', 'ASC')
            ->getQuery();
        $products = $query->getResult();

        $response = $products != null ?
            [
                'code' => 200,
                // 'error' => $error,
                'data' => $products,
            ] : [
                'code' => 404,
                'message' => 'Entity not found',
            ];
        return new Response($serializer->serialize($response, "json"), $status = $response["code"]);
    }

}
