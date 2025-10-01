<?php

namespace App\Controller;

use App\Repository\CarRepository;
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
            'controller_name' => 'CarController',
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
}

