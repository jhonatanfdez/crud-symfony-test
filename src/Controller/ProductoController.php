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

            // Mensaje flash de éxito
            $this->addFlash('success', 'El producto ha sido creado exitosamente');

            // Redirigir al listado de productos
            return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
        }

        // Mostrar el formulario de creación
        return $this->render('producto/new.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    /**
     * Muestra los detalles de un producto específico
     * 
     * El parámetro {id} en la ruta se convierte automáticamente en un objeto Producto
     * gracias al ParamConverter de Symfony. Si no existe, devuelve error 404.
     * Requiere autenticación para acceder.
     * 
     * @param Producto $producto - El producto a mostrar (cargado automáticamente por su ID)
     * @return Response - Respuesta HTTP con la vista de detalles
     */
    #[Route('/{id}', name: 'app_producto_show', methods: ['GET'])]
    public function show(Producto $producto): Response
    {
        // Verificar que el usuario esté autenticado antes de ver detalles
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // Renderizar la vista de detalles pasándole el producto
        return $this->render('producto/show.html.twig', [
            'producto' => $producto,
        ]);
    }

    /**
     * Edita un producto existente
     * 
     * Este método maneja tanto la visualización del formulario de edición (GET)
     * como el procesamiento de los datos modificados (POST).
     * Muestra el campo de usuario para permitir cambiar el responsable del producto.
     * Muestra el campo de fecha pero deshabilitado (solo lectura).
     * Requiere autenticación para acceder.
     * 
     * @param Request $request - Objeto que contiene los datos del formulario
     * @param Producto $producto - El producto a editar (cargado automáticamente)
     * @param EntityManagerInterface $entityManager - Gestor de entidades de Doctrine
     * @return Response - Respuesta HTTP (formulario o redirección)
     */
    #[Route('/{id}/edit', name: 'app_producto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        // Verificar que el usuario esté autenticado antes de permitir editar
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // Crear el formulario CON el campo user visible (show_user = true)
        // y CON el campo fecha visible pero deshabilitado (is_edit = true)
        // Esto permite que en la edición se pueda cambiar el usuario asignado al producto
        // pero NO se pueda modificar la fecha de creación
        $form = $this->createForm(ProductoType::class, $producto, [
            'show_user' => true,  // Mostrar el campo user en edición
            'is_edit' => true     // Mostrar el campo fecha deshabilitado
        ]);
        
        // Procesar la petición del formulario
        $form->handleRequest($request);

        // Verificar si el formulario fue enviado y es válido
        if ($form->isSubmitted() && $form->isValid()) {
            // Como el campo user está mapeado normalmente en el formulario,
            // Symfony automáticamente actualiza el usuario del producto
            // El campo fecha NO se actualiza porque está deshabilitado
            
            // Guardar los cambios en la base de datos
            // No necesitamos persist() porque el producto ya existe
            $entityManager->flush();

            // Mensaje flash de éxito
            $this->addFlash('success', 'El producto ha sido actualizado exitosamente');

            // Redirigir al listado de productos
            return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
        }

        // Si el formulario NO fue enviado o tiene errores, mostrar la vista de edición
        return $this->render('producto/edit.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    /**
     * Elimina un producto existente
     * 
     * Este método solo acepta peticiones POST para evitar eliminaciones accidentales.
     * Incluye protección CSRF para prevenir ataques de falsificación de peticiones.
     * Requiere autenticación para acceder.
     * 
     * @param Request $request - Objeto que contiene el token CSRF
     * @param Producto $producto - El producto a eliminar (cargado automáticamente)
     * @param EntityManagerInterface $entityManager - Gestor de entidades de Doctrine
     * @return Response - Redirección al listado de productos
     */
    #[Route('/{id}', name: 'app_producto_delete', methods: ['POST'])]
    public function delete(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        // Verificar que el usuario esté autenticado antes de permitir eliminar
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // Verificar que el token CSRF es válido para evitar ataques de falsificación
        // El token debe coincidir con el generado en el formulario de eliminación
        if ($this->isCsrfTokenValid('delete'.$producto->getId(), $request->getPayload()->getString('_token'))) {
            // Marcar el producto para eliminación
            $entityManager->remove($producto);
            
            // Ejecutar la eliminación en la base de datos
            $entityManager->flush();

            // Mensaje flash de éxito
            $this->addFlash('success', 'El producto ha sido eliminado exitosamente');
        }

        // Redirigir al listado de productos (se elimine o no)
        return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
    }
}
