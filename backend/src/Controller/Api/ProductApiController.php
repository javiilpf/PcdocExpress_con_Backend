<?php
namespace App\Controller\Api;

use App\Entity\Product;
use App\Entity\Image;
use App\Entity\Opinion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api/product', name: 'api_product_')]
class ProductApiController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $product = new Product();
            $product->setProductName($data['product_name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setStock($data['stock']);
            $product->setValoration($data['valoration']);
            $product->setType($data['type']);

            // Manejo de imágenes
            foreach ($data['images'] as $imageData) {
                $image = new Image();
                $image->setUrlImage($imageData['url_image']);
                $image->setTitle($imageData['title']);
                $product->addImage($image);
            }

            // Manejo de opiniones
            foreach ($data['opinions'] as $opinionData) {
                $opinion = new Opinion();
                $opinion->setOpinion($opinionData['opinion']);
                $product->addOpinion($opinion);
            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->json([
                'status' => 'success',
                'data' => $product
            ], 201, [], [
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                    return $object->getId();
                }
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        try {
            $products = $this->entityManager->getRepository(Product::class)->findAll();

            return $this->json([
                'status' => 'success',
                'data' => $products
            ], 200, [], [
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                    return $object->getId();
                }
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/{id}', name: 'details', methods: ['GET'])]
    public function details(int $id): JsonResponse
    {
        try {
            $product = $this->entityManager->getRepository(Product::class)->find($id);
            if (!$product) {
                return $this->json(['error' => 'Producto no encontrado'], 404);
            }

            return $this->json([
                'status' => 'success',
                'data' => $product
            ], 200, [], [
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                    return $object->getId();
                }
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
?>