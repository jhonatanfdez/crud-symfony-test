<?php

namespace App\Controller;

use App\Repository\CategoriaRepository;
use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(
        CategoriaRepository $categoriaRepo,
        ProductoRepository $productoRepo
    ): Response
    {
        // Obtener estadísticas
        $totalCategorias = count($categoriaRepo->findAll());
        $totalProductos = count($productoRepo->findAll());
        
        return $this->render('home/index.html.twig', [
            'totalCategorias' => $totalCategorias,
            'totalProductos' => $totalProductos,
        ]);
    }

    #[Route('/', name: 'app_root')]
    public function root(): Response
    {
        //return dd($this->getUser()); 
        // Si NO está autenticado, redirigir a login
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
    // Si está autenticado, mostrar home
    return $this->redirectToRoute('app_home');
    }
}
