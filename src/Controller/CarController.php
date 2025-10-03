<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(CarRepository $carRepository): Response
    {
        $cars = $carRepository->findAll();

/*        $output = '<h1>Liste des voitures</h1><ul>';
        foreach ($cars as $car) {
            $output .= '<li>' . $car->getName() . ' ' . $car->getSeats() . '</li>';
        }
        $output .= '</ul>';*/

        return $this->render('car/index.html.twig', [
            'cars' => $cars

        ]);
    }

    #[Route('/car/{id}', name: 'app_car_detail', requirements: ['id' => '\d+'])]
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

    #[Route('/car/{id}/delete', name: 'app_car_delete', requirements: ['id' => '\d+'])]
    public function delete(CarRepository $carRepository, int $id, EntityManagerInterface $em): Response
    {
        $car = $carRepository->find($id);
        // Vérifier si l'entité existe
        if (!$car) {
            // Rediriger vers la liste des auteurs si l'ID est invalide
            $this->addFlash('warning', 'Véhicule non trouvé.');
            return $this->redirectToRoute('app_car');
        }

        $em->remove($car);
        $em->flush();

        $this->addFlash('success', 'Véhicule supprimé avec succès.');
        return $this->redirectToRoute('app_car', [
            'car' => $car
        ]);
    }
}

