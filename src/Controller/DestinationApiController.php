<?php

namespace App\Controller;

use App\Entity\DestinationApi;
use App\Repository\DestinationApiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class DestinationApiController extends AbstractController
{
    #[Route('/destination', methods: ['GET'])]
    public function index(Request $requst, DestinationApiRepository $repo): JsonResponse
    {

        $page = ceil(max(1, (int) $requst->query->get('page', 1)));
        $limit = ceil(max(1, (int) $requst->query->get('limit', 10)));
        $qb = $repo->createQueryBuilder('d');
        $detination = $qb->setFirstResult(ceil(($page - 1) * $limit))
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        $total = $qb->select('COUNT(d.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->json([
            'destination' => $detination,
            'metaData' => [
                'totalRecord' => $total,
                'limitPerPage' => $limit,
                'totalPage' => ceil($total / $limit),
                'currentPage' => $page
            ]
        ], 200);
    }
    #[Route('/destination/{id<\d+>}', methods: ['GET'])]
    public function show(DestinationApi $destination): JsonResponse
    {
        return $this->json($destination, 200);
    }
    #[Route('/destination/{id<\d+>}', methods: ['DELETE'])]
    public function delete(?int $id, DestinationApiRepository $repo, EntityManagerInterface $em): JsonResponse
    {
        $destination = $repo->find($id);
        if (!$destination) {
            return $this->json([
                "Massege" => "Related recodr not found"
            ], 404);
        }
        $em->remove($destination);
        $em->flush();
        return $this->json($destination, 200);
    }
}
