<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/producto')]
final class ProductoController extends AbstractController
{
    /**
     * Muestra el listado de productos con opción de búsqueda
     * 
     * Este método maneja la página principal de productos.
     * Permite buscar productos por nombre si se proporciona un término de búsqueda.
     * 
     * @param Request $request - Objeto que contiene los datos de la petición HTTP (incluye parámetros GET)
     * @param ProductoRepository $productoRepository - Repositorio para acceder a la base de datos
     * @return Response - Respuesta HTTP con la vista renderizada
     */
    #[Route(name: 'app_producto_index', methods: ['GET'])]
    public function index(Request $request, ProductoRepository $productoRepository): Response
    {
        // Verificar que el usuario esté autenticado antes de mostrar el listado
        // Si no está autenticado, Symfony lo redirigirá automáticamente al login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // Obtener el parámetro 'search' de la URL (parámetro GET)
        // Por ejemplo: /producto?search=laptop
        // Si no existe el parámetro, $searchTerm será null
        $searchTerm = $request->query->get('search');
        
        // Buscar productos usando el método que creamos en el repositorio
        // Si $searchTerm es null o vacío, el método retornará todos los productos
        // Si tiene un valor, retornará solo los que coincidan con el nombre
        $productos = $productoRepository->findByNombre($searchTerm);
        
        // Renderizar la vista y pasarle dos variables:
        // - productos: array con los productos encontrados
        // - searchTerm: el término de búsqueda (para mostrarlo en el campo de búsqueda)
        return $this->render('producto/index.html.twig', [
            'productos' => $productos,
            'searchTerm' => $searchTerm,  // Pasar el término de búsqueda a la vista
        ]);
    }

    #[Route('/new', name: 'app_producto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Verificar que el usuario esté autenticado antes de permitir crear productos
        // Si no está autenticado, Symfony lo redirigirá automáticamente al login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // Crear una nueva instancia de Producto
        $producto = new Producto();
        
        // Crear el formulario SIN el campo user y SIN el campo fecha
        // show_user = false: el usuario no verá el campo user (se asigna automáticamente)
        // is_edit = false: el campo fecha NO aparecerá (se crea automáticamente con PrePersist)
        $form = $this->createForm(ProductoType::class, $producto, [
            'is_edit' => false
        ]);
        
        // Procesar la petición del formulario
        $form->handleRequest($request);

        // Verificar si el formulario fue enviado y es válido
        if ($form->isSubmitted() && $form->isValid()) {
            // IMPORTANTE: Asignar automáticamente el usuario actual al producto
            // Esto se hace DESPUÉS de validar el formulario para asegurar que
            // el producto tenga un usuario antes de guardarlo en la base de datos
            // $this->getUser() obtiene el usuario que está logueado actualmente
            $producto->setUser($this->getUser());
            
            // Preparar el producto para ser guardado
            $entityManager->persist($producto);
            
            // Ejecutar la inserción en la base de datos
            $entityManager->flush();

            // Redirigir al listado de productos
            return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
        }

        // Mostrar el formulario de creación
        return $this->render('producto/new.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_producto_show', methods: ['GET'])]
    public function show(Producto $producto): Response
    {
        // Verificar que el usuario esté autenticado antes de ver detalles
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        return $this->render('producto/show.html.twig', [
            'producto' => $producto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_producto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        // Verificar que el usuario esté autenticado antes de permitir editar
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // Crear el formulario CON el campo user visible (show_user = true)
        // Esto permite que en la edición se pueda cambiar el usuario asignado al producto
        // El formulario automáticamente cargará el usuario actual del producto
        $form = $this->createForm(ProductoType::class, $producto, [
            'show_user' => true, 'is_edit' => true   // Mostrar el campo user en edición
        ]);
        
        // Procesar la petición del formulario
        $form->handleRequest($request);

        // Verificar si el formulario fue enviado y es válido
        if ($form->isSubmitted() && $form->isValid()) {
            // Como el campo user está mapeado normalmente en el formulario,
            // Symfony automáticamente actualiza el usuario del producto
            // No necesitamos hacer nada manual aquí
            
            // Guardar los cambios en la base de datos
            $entityManager->flush();

            // Redirigir al listado de productos
            return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
        }

        // Mostrar el formulario de edición
        return $this->render('producto/edit.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_producto_delete', methods: ['POST'])]
    public function delete(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        // Verificar que el usuario esté autenticado antes de permitir eliminar
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // Verificar el token CSRF para seguridad (previene ataques)
        if ($this->isCsrfTokenValid('delete'.$producto->getId(), $request->getPayload()->getString('_token'))) {
            // Marcar el producto para eliminación
            $entityManager->remove($producto);
            
            // Ejecutar la eliminación en la base de datos
            $entityManager->flush();
        }

        // Redirigir al listado de productos
        return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
    }
}
