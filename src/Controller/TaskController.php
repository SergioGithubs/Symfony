<?php

namespace App\Controller;

use App\Repository\TaskRepository;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CollaboratorController
 * @Route("/api/task")
 */
class TaskController extends AbstractFOSRestController
{
    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getTask($id, TaskRepository $taskRepository, SerializerInterface $serializer)
    {
        $task = $taskRepository->find($id);
        $response = $task != null ?
            [
                'code' => 200,
                // 'error' => $error,
                'data' => $task,
            ] : [
                'code' => 404,
                'message' => 'Entity not found',
            ];
        return new Response($serializer->serialize($response, "json"));
        // return new Response($serializer->serialize($response, "json"), $status = 200);
    }

    /**
     * @Route("/", methods={"PUT"})
     */
    public function postTask(
        Request $request,
        TaskRepository $taskRepository,
        SerializerInterface $serializer
    ) {
        $title = $request->get('title', "no_name");
        $list_id = $request->get('list_id');
        $taskRepository->createTask($title, $list_id);
        $response = [
            'code' => 200,
            'message' => 'Entity created'
        ];
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Route("/toggle/{id}", methods={"POST"})
     */
    public function toggleTask(
        $id,
        TaskRepository $taskRepository,
        SerializerInterface $serializer
    ) {
        $taskRepository->toggleTask($id);
        $response = [
            'code' => 200,
            'message' => 'Entity updated'
        ];
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function deleteTask(
        $id,
        TaskRepository $taskRepository,
        SerializerInterface $serializer
    ) {
        $taskRepository->deleteTask($id);
        $response = [
            'code' => 200,
            'message' => 'Entity delete'
        ];
        return new Response($serializer->serialize($response, "json"));
    }
}
