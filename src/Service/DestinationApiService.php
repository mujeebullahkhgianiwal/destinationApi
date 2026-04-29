<?php

namespace App\Service;

use App\Entity\DestinationApi;
use App\Repository\DestinationApiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DestinationApiService
{

    private DestinationApiRepository $destinationApiRepository;
    private SerializerInterface $serializerInterface;
    private ValidatorInterface $validatorInterface;
    private EntityManagerInterface $entityManagerInterface;
    public function __construct(DestinationApiRepository $destinationApiRepository, SerializerInterface $serializerInterface, ValidatorInterface $validatorInterface, EntityManagerInterface $entityManagerInterface)
    {

        $this->destinationApiRepository = $destinationApiRepository;
        $this->serializerInterface = $serializerInterface;
        $this->validatorInterface = $validatorInterface;
        $this->entityManagerInterface = $entityManagerInterface;
    }
    public function index(?int $page, ?int $limit)
    {
        $qb = $this->destinationApiRepository->createQueryBuilder('d');
        $qbt = $qb;
        $detination = $qb->setFirstResult(ceil(($page - 1) * $limit))
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        $total = $qbt->select('COUNT(d.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return [
            [
                'destination' => $detination,
                'metaData' => [
                    'totalRecord' => $total,
                    'limitPerPage' => $limit,
                    'totalPage' => ceil($total / $limit),
                    'currentPage' => $page
                ]
            ],
            200
        ];
    }
    public function show(?int $id)
    {
        $destination = $this->destinationApiRepository->find($id);
        if (!$destination) {
            return [[
                "Massege" => "Related recodr not found"
            ], 404];
        }
        return [$destination, 200];
    }
    public function delete(?int $id)
    {
        $destination = $this->destinationApiRepository->find($id);

        if (!$destination) {
            return [
                [
                    "message" => "Related record not found"
                ],
                404
            ];
        }
        $this->entityManagerInterface->remove($destination);
        $this->entityManagerInterface->flush();
        return [
            [
                "message" => "Record deleted successfully"
            ],
            200
        ];
    }
    public function update(?int $id, $data)
    {
        $destination = $this->destinationApiRepository->find($id);
        if (!$destination) {
            return [[
                "Massege" => "Related recodr not found"
            ], 404];
        }
        $destination = $this->serializerInterface->deserialize($data, DestinationApi::class, 'json', [
            'object_to_populate' => $destination
        ]);
        $errors = $this->validatorInterface->validate($destination);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
            }
            return [$errorMessages, 422];
        }
        $this->entityManagerInterface->flush();
        return [$destination, 201];
    }
    public function create($data)
    {
        $destination = $this->serializerInterface->deserialize($data, DestinationApi::class, 'json');
        $errors = $this->validatorInterface->validate($destination);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
            }

            return [$errorMessages, 422];
        }
        $this->entityManagerInterface->persist($destination);
        $this->entityManagerInterface->flush();

        return [$destination, 201];
    }
    public function search(?int $page, ?int $limit, ?float $maxBudget, ?string $activities, ?string $travelMonth): array
    {
        $qb = $this->destinationApiRepository->createQueryBuilder('d');
        $bqt = $qb;

        if ($maxBudget) {
            $qb->orWhere('d.budget <= :maxBudget')
                ->setParameter('maxBudget', $maxBudget);
        }
        if ($activities) {
            $qb->orWhere('d.activities LIKE :activities')
                ->setParameter('activities', "%{$activities}%");
        }
        if ($travelMonth) {
            $qb->orWhere('d.travelMonth = :travelMonth')
                ->setParameter('travelMonth', $travelMonth);
        }

        $total = (int) $bqt->select('COUNT(d.id)')->getQuery()->getSingleScalarResult();


        $destinations = $qb->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return [
            [
                'destinations' => $destinations,
                'metaData' => [
                    'totalRecord' => $total,
                    'limitPerPage' => $limit,
                    'totalPage' =>  ceil($total / $limit),
                    'currentPage' => $page
                ]
            ],
            200
        ];
    }
}
