<?php

namespace App\Controller;

use App\Repository\CategoriaRepository;
use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controlador de la página de inicio
 * 
 * Maneja la ruta raíz (/) y la página de inicio (/home).
 * Muestra estadísticas básicas del sistema (total de categorías y productos).
 * 
 * @package App\Controller
 */
final class HomeController extends AbstractController
{
    /**
     * Página de inicio del sistema (Dashboard)
     * 
     * Muestra estadísticas básicas del sistema:
     * - Total de categorías
     * - Total de productos
     * 
     * @param CategoriaRepository $categoriaRepo - Repositorio para consultar categorías
     * @param ProductoRepository $productoRepo - Repositorio para consultar productos
     * @return Response - Respuesta HTTP con la vista renderizada
     */
    #[Route('/home', name: 'app_home')]
    public function index(
        CategoriaRepository $categoriaRepo,
        ProductoRepository $productoRepo
    ): Response
    {
        // Obtener el total de categorías contando todos los registros
        $totalCategorias = count($categoriaRepo->findAll());
        
        // Obtener el total de productos contando todos los registros
        $totalProductos = count($productoRepo->findAll());
        
        // Renderizar la vista del dashboard pasándole las estadísticas
        return $this->render('home/index.html.twig', [
            'totalCategorias' => $totalCategorias,
            'totalProductos' => $totalProductos,
        ]);
    }

    /**
     * Ruta raíz del sitio web (/)
     * 
     * Redirige al usuario según su estado de autenticación:
     * - Si NO está autenticado: redirige a /login
     * - Si está autenticado: redirige a /home (dashboard)
     * 
     * @return Response - Redirección a login o home
     */
    #[Route('/', name: 'app_root')]
    public function root(): Response
    {
        // Verificar si el usuario está autenticado
        // $this->getUser() retorna el usuario actual o null si no hay sesión
        if (!$this->getUser()) {
            // Usuario no autenticado: redirigir a la página de login
            return $this->redirectToRoute('app_login');
        }
        
        // Usuario autenticado: redirigir a la página de inicio
        return $this->redirectToRoute('app_home');
    }
}
