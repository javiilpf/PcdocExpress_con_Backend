<?php

namespace App\Controller\Api;

use App\Entity\Maintenance;
use App\Entity\User;
use App\Enum\DispositiveType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('api/maintenance', name: 'api_maintenance_')]
class MaintenanceApiController extends AbstractController

{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    #[Route('/user/{id}', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
    try {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Usuario no autenticado'], 401);
        }

        $maintenances = $this->entityManager
            ->getRepository(Maintenance::class)
            ->findBy(['idClient' => $user]);

        return $this->json([
            'status' => 'success',
            'data' => $maintenances
        ], 200, [], [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES => [
                'id',
                'deviceType',
                'model',
                'processor',
                'ram',
                'storage',
                'specifications',
                'maintenanceDate',
                'state',
                'valoration',
                'idClient' => ['id', 'email'],
                'idAdministrator' => ['id', 'email']
            ]
        ]);
    } catch (\Exception $e) {
        return $this->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            /** @var User $user */
            $user = $this->getUser();
            if (!$user) {
                return $this->json(['error' => 'Usuario no autenticado'], 401);
            }

            $data = json_decode($request->getContent(), true);
            if (!$data) {
                return $this->json(['error' => 'JSON inválido'], 400);
            }

            $maintenance = new Maintenance();
            $maintenance->setDeviceType(DispositiveType::from($data['deviceType']));
            $maintenance->setModel($data['model']);
            $maintenance->setProcessor($data['processor']);
            $maintenance->setRam($data['ram']);
            $maintenance->setStorage($data['storage']);
            $maintenance->setSpecifications($data['specifications']);
            $maintenance->setMaintenanceDate(new \DateTime());
            $maintenance->setState(1);
            $maintenance->setIdClient($user);

            $this->entityManager->persist($maintenance);
            $this->entityManager->flush();

            return $this->json([
                'status' => 'success',
                'message' => 'Mantenimiento creado correctamente',
                'data' => $maintenance
            ], 201, [], [
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                    return $object->getId();
                },
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'deviceType',
                    'model',
                    'processor',
                    'ram',
                    'storage',
                    'specifications',
                    'maintenanceDate',
                    'state',
                    'valoration',
                    'idClient' => ['id', 'email']
                ]
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 