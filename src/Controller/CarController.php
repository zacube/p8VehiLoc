<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/car', name: 'app_car_')]
final class CarController extends AbstractController
{

    #[Route('', name: 'index', methods: ['GET'])]
    #[Route('/', name: 'root', methods: ['GET'])]
    public function index(CarRepository $carRepository): Response
    {
        $cars = $carRepository->findAll();



        return $this->render('car/index.html.twig', [
            'cars' => $cars

        ]);
    }

    #[Route('/{id}', name: 'detail', requirements: ['id' => '\d+'])]
    public function detail(CarRepository $carRepository, int $id): Response
    {
        $car = $carRepository->find($id);
        if (!$car) {
            throw $this->createNotFoundException("La voiture $id n’existe pas.");
        }

        return $this->render('car/detail.html.twig', [
            'car' => $car

        ]);
    }

    #[Route('/{id}/delete', name: 'delete', requirements: ['id' => '\d+'])]
    public function delete(CarRepository $carRepository, int $id, EntityManagerInterface $em): Response
    {
        $car = $carRepository->find($id);
        // Vérifier si l'entité existe
        if (!$car) {
            // Rediriger vers la liste des auteurs si l'ID est invalide
            $this->addFlash('warning', 'Véhicule non trouvé.');
            return $this->redirectToRoute('app_car_index');
        }

        $em->remove($car);
        $em->flush();

        $this->addFlash('success', 'Véhicule supprimé avec succès.');
        return $this->redirectToRoute('app_car_index', [
            'car' => $car]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $car = new Car;
        $form = $this->createForm(CarType::class, $car);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($car);
            $em->flush();

            $this->addFlash('success', 'Nouveau véhicule ajouté.');
            return $this->redirectToRoute('app_car_index');
        }

        return $this->render('car/new.html.twig', [
            'form' => $form,
        ]);
    }
}

