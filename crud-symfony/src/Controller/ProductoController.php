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
    #[Route(name: 'app_producto_index', methods: ['GET'])]
    public function index(ProductoRepository $productoRepository): Response
    {
        // Verificar que el usuario esté autenticado antes de mostrar el listado
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        return $this->render('producto/index.html.twig', [
            'productos' => $productoRepository->findAll(),
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
        
        // Crear el formulario SIN el campo user (show_user = false por defecto)
        // Esto significa que el usuario no verá ni podrá modificar el campo user
        $form = $this->createForm(ProductoType::class, $producto);
        
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
            'show_user' => true  // Mostrar el campo user en edición
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
