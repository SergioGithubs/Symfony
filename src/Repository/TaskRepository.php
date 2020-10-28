<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, TaskListRepository $taskListRepository)
    {
        parent::__construct($registry, Task::class);
        $this->taskListRepository  = $taskListRepository;
    }

    public function createTask($title, $list_id)
    {
        $task = new Task();
        $task->setTitle($title);
        $entityManager = $this->getEntityManager();
        if ($list_id != null) {
            /** @var TaskList $listRepo */
            $listRepo = $this->taskListRepository->find($list_id);
            $task->setTaskList($listRepo);
            $listRepo->addTask($task);
            $entityManager->persist($listRepo);
        }
        $task->setIsDone(false);
        $entityManager->persist($task);
        $entityManager->flush();
    }

    public function toggleTask($id)
    {
        $entityManager = $this->getEntityManager();
        $task = $this->find($id);
        $task->setIsDone(!$task->getIsDone());
        $entityManager->persist($task);
        $entityManager->flush();
    }

    public function deleteTask($id)
    {
        $entityManager = $this->getEntityManager();
        $task = $this->find($id);
        $entityManager->remove($task);
        $entityManager->flush();
    }
}
