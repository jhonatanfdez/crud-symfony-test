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

    /**
     * Crea una nueva categoría
     * 
     * Este método maneja tanto la visualización del formulario (GET)
     * como el procesamiento de los datos enviados (POST).
     * 
     * @param Request $request - Objeto que contiene los datos del formulario
     * @param EntityManagerInterface $entityManager - Gestor de entidades de Doctrine
     * @return Response - Respuesta HTTP (formulario o redirección)
     */
    #[Route('/new', name: 'app_categoria_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Verificar que el usuario tenga rol ADMIN
        // Si no tiene el rol, redirige al index y muestra mensaje flash
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Usted no tiene privilegios para esta acción');
            return $this->redirectToRoute('app_categoria_index');
        }
        
        // Crear una nueva instancia vacía de Categoria
        $categorium = new Categoria();
        
        // Crear el formulario asociado a esta categoría
        $form = $this->createForm(CategoriaType::class, $categorium);
        
        // Procesar los datos de la petición (si el formulario fue enviado)
        $form->handleRequest($request);

        // Verificar si el formulario fue enviado Y si pasó todas las validaciones
        if ($form->isSubmitted() && $form->isValid()) {
            // Preparar la categoría para ser guardada (marcarla como "pendiente")
            $entityManager->persist($categorium);
            
            // Ejecutar la inserción en la base de datos
            $entityManager->flush();

            // Redirigir al listado de categorías con código HTTP 303 (See Other)
            return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        // Si el formulario NO fue enviado o tiene errores, mostrar la vista con el formulario
        return $this->render('categoria/new.html.twig', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    /**
     * Muestra los detalles de una categoría específica
     * 
     * El parámetro {id} en la ruta se convierte automáticamente en un objeto Categoria
     * gracias al ParamConverter de Symfony. Si no existe, devuelve error 404.
     * 
     * @param Categoria $categorium - La categoría a mostrar (cargada automáticamente por su ID)
     * @return Response - Respuesta HTTP con la vista de detalles
     */
    #[Route('/{id}', name: 'app_categoria_show', methods: ['GET'])]
    public function show(Categoria $categorium): Response
    {
        // Renderizar la vista de detalles pasándole la categoría
        return $this->render('categoria/show.html.twig', [
            'categorium' => $categorium,
        ]);
    }

    /**
     * Edita una categoría existente
     * 
     * Este método maneja tanto la visualización del formulario de edición (GET)
     * como el procesamiento de los datos modificados (POST).
     * 
     * @param Request $request - Objeto que contiene los datos del formulario
     * @param Categoria $categorium - La categoría a editar (cargada automáticamente)
     * @param EntityManagerInterface $entityManager - Gestor de entidades de Doctrine
     * @return Response - Respuesta HTTP (formulario o redirección)
     */
    #[Route('/{id}/edit', name: 'app_categoria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categoria $categorium, EntityManagerInterface $entityManager): Response
    {
        // Verificar que el usuario tenga rol ADMIN
        // Si no tiene el rol, redirige al index y muestra mensaje flash
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Usted no tiene privilegios para esta acción');
            return $this->redirectToRoute('app_categoria_index');
        }
        
        // Crear el formulario prellenado con los datos de la categoría existente
        $form = $this->createForm(CategoriaType::class, $categorium);
        
        // Procesar los datos de la petición (si el formulario fue enviado)
        $form->handleRequest($request);

        // Verificar si el formulario fue enviado Y si pasó todas las validaciones
        if ($form->isSubmitted() && $form->isValid()) {
            // Como la categoría ya existe en la BD, solo necesitamos flush()
            // No es necesario persist() porque Doctrine ya está "rastreando" esta entidad
            $entityManager->flush();

            // Redirigir al listado de categorías
            return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        // Si el formulario NO fue enviado o tiene errores, mostrar la vista de edición
        return $this->render('categoria/edit.html.twig', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    /**
     * Elimina una categoría existente
     * 
     * Este método solo acepta peticiones POST para evitar eliminaciones accidentales.
     * Incluye protección CSRF para prevenir ataques de falsificación de peticiones.
     * 
     * @param Request $request - Objeto que contiene el token CSRF
     * @param Categoria $categorium - La categoría a eliminar (cargada automáticamente)
     * @param EntityManagerInterface $entityManager - Gestor de entidades de Doctrine
     * @return Response - Redirección al listado de categorías
     */
    #[Route('/{id}', name: 'app_categoria_delete', methods: ['POST'])]
    public function delete(Request $request, Categoria $categorium, EntityManagerInterface $entityManager): Response
    {
        // Verificar que el usuario tenga rol ADMIN
        // Si no tiene el rol, redirige al index y muestra mensaje flash
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Usted no tiene privilegios para esta acción');
            return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
        }
        
        // Verificar que el token CSRF es válido para evitar ataques de falsificación
        // El token debe coincidir con el generado en el formulario de eliminación
        if ($this->isCsrfTokenValid('delete'.$categorium->getId(), $request->getPayload()->getString('_token'))) {
            // Marcar la categoría para ser eliminada
            $entityManager->remove($categorium);
            
            // Ejecutar la eliminación en la base de datos
            $entityManager->flush();
        }

        // Redirigir al listado de categorías (se elimine o no)
        return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
    }
}
