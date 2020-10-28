<?php

namespace App\Controller;

use App\Repository\TaskListRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CollaboratorController
 * @Route("/api/list")
 */
class TaskListController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/{id}", name="get_task")
     */
    public function getTaskList($id, TaskListRepository $taskListRepository, SerializerInterface $serializer)
    {
        $taskList = $taskListRepository->find($id);
        $response = $taskList != null ?
            [
                'code' => 200,
                'data' => $taskList
            ] : [
                'code' => 404,
                'message' => 'Entity not found',
            ];
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Post("/", name="post_task")
     */
    public function postTaskList(
        Request $request,
        TaskListRepository $taskListRepository,
        SerializerInterface $serializer
    ) {
        $title = $request->get('title', "no_name");
        $taskListRepository->createTaskList($title);
        $response = [
            'code' => 200,
            'message' => 'Entity created'
        ];
        return new Response($serializer->serialize($response, "json"));
    }
}
