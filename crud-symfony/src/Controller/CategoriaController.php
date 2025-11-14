<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categoria')]
final class CategoriaController extends AbstractController
{
    /**
     * Muestra el listado de categorías con opción de búsqueda
     * 
     * Este método maneja la página principal de categorías.
     * Permite buscar categorías por nombre si se proporciona un término de búsqueda.
     * 
     * @param Request $request - Objeto que contiene los datos de la petición HTTP (incluye parámetros GET)
     * @param CategoriaRepository $categoriaRepository - Repositorio para acceder a la base de datos
     * @return Response - Respuesta HTTP con la vista renderizada
     */
    #[Route(name: 'app_categoria_index', methods: ['GET'])]
    public function index(Request $request, CategoriaRepository $categoriaRepository): Response
    {
        // Obtener el parámetro 'search' de la URL (parámetro GET)
        // Por ejemplo: /categoria?search=laptops
        // Si no existe el parámetro, $searchTerm será null
        $searchTerm = $request->query->get('search');
        
        // Buscar categorías usando el método que creamos en el repositorio
        // Si $searchTerm es null o vacío, el método retornará todas las categorías
        // Si tiene un valor, retornará solo las que coincidan con el nombre
        $categorias = $categoriaRepository->findByNombre($searchTerm);
        
        // Renderizar la vista y pasarle dos variables:
        // - categorias: array con las categorías encontradas
        // - searchTerm: el término de búsqueda (para mostrarlo en el campo de búsqueda)
        return $this->render('categoria/index.html.twig', [
            'categorias' => $categorias,
            'searchTerm' => $searchTerm,  // Pasar el término de búsqueda a la vista
        ]);
    }

    #[Route('/new', name: 'app_categoria_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorium = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorium);
            $entityManager->flush();

            return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categoria/new.html.twig', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categoria_show', methods: ['GET'])]
    public function show(Categoria $categorium): Response
    {
        return $this->render('categoria/show.html.twig', [
            'categorium' => $categorium,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categoria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categoria $categorium, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categoria/edit.html.twig', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categoria_delete', methods: ['POST'])]
    public function delete(Request $request, Categoria $categorium, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorium->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($categorium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
    }
}
