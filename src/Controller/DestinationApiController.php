<?php

namespace App\Controller;

use App\Service\DestinationApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DestinationApiController extends AbstractController
{
    private DestinationApiService $destinationApiService;
    public function __construct(DestinationApiService $destinationApiService)
    {
        $this->destinationApiService = $destinationApiService;
    }

    #[Route('/destinations', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $page = ceil(max(1, (int) $request->query->get('page', 1)));
        $limit = ceil(max(1, (int) $request->query->get('limit', 10)));
        return $this->json($this->destinationApiService->index($page, $limit));
    }
    #[Route('/destinations/{id<\d+>}', methods: ['GET'])]
    public function show(?int $id): JsonResponse
    {
        return $this->json($this->destinationApiService->show($id));
    }
    #[Route('/destinations/{id<\d+>}', methods: ['DELETE'])]
    public function delete(?int $id): JsonResponse
    {
        return $this->json($this->destinationApiService->delete($id));
    }
    #[Route('/destinations/{id<\d+>}', methods: ['PUT', 'PATCH'])]
    public function update(?int $id, Request $request): JsonResponse
    {
        $data = $request->getContent();

        return $this->json($this->destinationApiService->update($id, $data));
    }
    #[Route('/destinations', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = $request->getContent();
        return $this->json($this->destinationApiService->create($data));
    }
    #[Route('/destinations/search', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $page = ceil(max(1, (int) $request->query->get('page', 1)));
        $limit = ceil(max(1, (int) $request->query->get('limit', 10)));
        $maxBudget = (float) $request->query->get('maxBudget');
        $activities = $request->query->get('activities');
        $travelMonth = $request->query->get('travelMonth');
        return $this->json($this->destinationApiService->search($page, $limit, $maxBudget, $activities, $travelMonth));
    }
}
