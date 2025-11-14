<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * API REST para gestión de productos
 * 
 * Este controlador proporciona endpoints JSON para operaciones CRUD sobre productos.
 * Todas las rutas están bajo el prefijo /api/producto
 * 
 * Endpoints disponibles:
 * - GET    /api/producto      → Listar todos los productos
 * - GET    /api/producto/{id} → Obtener un producto específico
 * - POST   /api/producto      → Crear nuevo producto
 * - PUT    /api/producto/{id} → Actualizar producto existente
 * - DELETE /api/producto/{id} → Eliminar producto
 * 
 * Formato de respuesta: JSON
 * Autenticación: Sesión Symfony (cookies) - Opcional según configuración
 */
#[Route('/api/producto', name: 'api_producto_')]
class ProductoApiController extends AbstractController
{
    /**
     * Lista todos los productos en formato JSON
     * 
     * Este endpoint retorna un array con todos los productos de la base de datos.
     * Cada producto incluye información de su categoría y usuario creador.
     * 
     * Endpoint: GET /api/producto
     * 
     * Respuesta exitosa (200 OK):
     * [
     *   {
     *     "id": 1,
     *     "nombre": "Laptop Dell",
     *     "precio": 1200.50,
     *     "fecha": "2025-11-13",
     *     "categoria": {"id": 1, "nombre": "Electrónica"},
     *     "usuario": {"id": 1, "email": "admin@test.com"}
     *   }
     * ]
     * 
     * @param ProductoRepository $productoRepository - Repositorio para acceder a productos
     * @return JsonResponse - Array de productos en formato JSON
     */
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(ProductoRepository $productoRepository): JsonResponse
    {
        // Obtener todos los productos de la base de datos
        $productos = $productoRepository->findAll();
        
        // Convertir cada producto a un array asociativo
        // Esto evita problemas de serialización circular (Producto → Categoria → Productos)
        $data = [];
        foreach ($productos as $producto) {
            $data[] = [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'precio' => $producto->getPrecio(),
                'fecha' => $producto->getFecha()->format('Y-m-d'), // Formato ISO 8601
                'categoria' => [
                    'id' => $producto->getCategoria()->getId(),
                    'nombre' => $producto->getCategoria()->getNombre(),
                ],
                'usuario' => [
                    'id' => $producto->getUser()->getId(),
                    'email' => $producto->getUser()->getEmail(),
                ]
            ];
        }
        
        // Retornar array en formato JSON con código HTTP 200 OK
        return $this->json($data);
    }
    
    /**
     * Muestra un producto específico en formato JSON
     * 
     * Este endpoint retorna los detalles completos de un producto por su ID.
     * Si el producto no existe, Symfony retorna automáticamente un error 404.
     * 
     * Endpoint: GET /api/producto/{id}
     * 
     * Parámetros de ruta:
     * - id (int): ID del producto a consultar
     * 
     * Respuesta exitosa (200 OK):
     * {
     *   "id": 1,
     *   "nombre": "Laptop Dell",
     *   "precio": 1200.50,
     *   "fecha": "2025-11-13",
     *   "categoria": {"id": 1, "nombre": "Electrónica"},
     *   "usuario": {"id": 1, "email": "admin@test.com"}
     * }
     * 
     * Respuesta de error (404 Not Found):
     * Si el producto no existe, Symfony retorna error 404 automáticamente
     * 
     * @param Producto $producto - Producto cargado automáticamente por ParamConverter
     * @return JsonResponse - Datos del producto en formato JSON
     */
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Producto $producto): JsonResponse
    {
        // Convertir el producto a array asociativo con toda su información
        $data = [
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
            'precio' => $producto->getPrecio(),
            'fecha' => $producto->getFecha()->format('Y-m-d'),
            'categoria' => [
                'id' => $producto->getCategoria()->getId(),
                'nombre' => $producto->getCategoria()->getNombre(),
            ],
            'usuario' => [
                'id' => $producto->getUser()->getId(),
                'email' => $producto->getUser()->getEmail(),
            ]
        ];
        
        // Retornar producto en formato JSON con código HTTP 200 OK
        return $this->json($data);
    }
    
    /**
     * Crea un nuevo producto desde datos JSON
     * 
     * Este endpoint permite crear un producto enviando datos en formato JSON.
     * El usuario creador se asigna automáticamente desde la sesión actual.
     * La fecha se asigna automáticamente si no se proporciona.
     * 
     * Endpoint: POST /api/producto
     * 
     * Headers requeridos:
     * - Content-Type: application/json
     * 
     * Body JSON ejemplo:
     * {
     *   "nombre": "Laptop Dell XPS 15",
     *   "precio": 1200.50,
     *   "categoria_id": 1,
     *   "fecha": "2025-11-13" (opcional)
     * }
     * 
     * Campos requeridos:
     * - nombre (string): Nombre del producto
     * - precio (float): Precio del producto
     * - categoria_id (int): ID de la categoría existente
     * 
     * Respuesta exitosa (201 Created):
     * {
     *   "mensaje": "Producto creado exitosamente",
     *   "producto": {
     *     "id": 5,
     *     "nombre": "Laptop Dell XPS 15",
     *     "precio": 1200.50,
     *     "fecha": "2025-11-13",
     *     "categoria": {"id": 1, "nombre": "Electrónica"},
     *     "usuario": {"id": 1, "email": "admin@test.com"}
     *   }
     * }
     * 
     * Posibles errores:
     * - 400 Bad Request: JSON inválido o faltan campos requeridos
     * - 404 Not Found: La categoría especificada no existe
     * 
     * @param Request $request - Objeto con los datos de la petición HTTP
     * @param EntityManagerInterface $entityManager - Gestor de entidades de Doctrine
     * @param CategoriaRepository $categoriaRepository - Repositorio para buscar categorías
     * @return JsonResponse - Respuesta con el producto creado o mensaje de error
     */
    #[Route('', name: 'create', methods: ['POST'])]
    public function create(
        Request $request, 
        EntityManagerInterface $entityManager,
        CategoriaRepository $categoriaRepository
    ): JsonResponse
    {
        // NOTA: Autenticación desactivada para facilitar pruebas educativas
        // En producción, descomentar la siguiente línea:
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // Obtener el contenido JSON del body de la petición
        // getContent() retorna el raw body como string
        $data = json_decode($request->getContent(), true);
        
        // Validar que el JSON es válido y no está vacío
        // json_decode retorna null si el JSON es inválido
        if (!$data) {
            return $this->json([
                'error' => 'JSON inválido o vacío'
            ], Response::HTTP_BAD_REQUEST); // Código 400
        }
        
        // Validar que se enviaron todos los campos obligatorios
        // isset() verifica que la clave existe en el array
        if (!isset($data['nombre']) || !isset($data['precio']) || !isset($data['categoria_id'])) {
            return $this->json([
                'error' => 'Faltan campos requeridos: nombre, precio, categoria_id'
            ], Response::HTTP_BAD_REQUEST); // Código 400
        }
        
        // Buscar la categoría en la base de datos por su ID
        // Si no existe, find() retorna null
        $categoria = $categoriaRepository->find($data['categoria_id']);
        if (!$categoria) {
            return $this->json([
                'error' => 'Categoría no encontrada'
            ], Response::HTTP_NOT_FOUND); // Código 404
        }
        
        // Crear una nueva instancia de Producto
        $producto = new Producto();
        
        // Asignar los valores recibidos del JSON
        $producto->setNombre($data['nombre']);
        $producto->setPrecio($data['precio']);
        $producto->setCategoria($categoria);
        
        // Asignar el usuario autenticado como creador del producto
        // getUser() obtiene el usuario de la sesión actual
        $producto->setUser($this->getUser());
        
        // La fecha se asigna automáticamente con @ORM\PrePersist
        // Pero permitimos que el cliente la especifique si lo desea
        if (isset($data['fecha'])) {
            $producto->setFecha(new \DateTime($data['fecha']));
        }
        
        // Marcar el producto para ser insertado en la base de datos
        $entityManager->persist($producto);
        
        // Ejecutar la inserción en la base de datos
        // flush() ejecuta todas las operaciones pendientes (INSERT, UPDATE, DELETE)
        $entityManager->flush();
        
        // Retornar respuesta exitosa con el producto creado
        return $this->json([
            'mensaje' => 'Producto creado exitosamente',
            'producto' => [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'precio' => $producto->getPrecio(),
                'fecha' => $producto->getFecha()->format('Y-m-d'),
                'categoria' => [
                    'id' => $producto->getCategoria()->getId(),
                    'nombre' => $producto->getCategoria()->getNombre(),
                ],
                'usuario' => [
                    'id' => $producto->getUser()->getId(),
                    'email' => $producto->getUser()->getEmail(),
                ]
            ]
        ], Response::HTTP_CREATED); // Código 201
    }
    
    /**
     * Actualiza un producto existente con datos JSON
     * 
     * Este endpoint permite actualizar parcialmente un producto.
     * Solo se actualizan los campos que se envían en el JSON.
     * Los campos no enviados mantienen su valor actual.
     * 
     * Endpoint: PUT /api/producto/{id}
     * 
     * Parámetros de ruta:
     * - id (int): ID del producto a actualizar
     * 
     * Headers requeridos:
     * - Content-Type: application/json
     * 
     * Body JSON ejemplo:
     * {
     *   "nombre": "Laptop Dell XPS 17",
     *   "precio": 1500.00,
     *   "categoria_id": 2
     * }
     * 
     * Campos opcionales (se actualiza solo lo enviado):
     * - nombre (string): Nuevo nombre del producto
     * - precio (float): Nuevo precio del producto
     * - categoria_id (int): ID de la nueva categoría
     * 
     * Respuesta exitosa (200 OK):
     * {
     *   "mensaje": "Producto actualizado exitosamente",
     *   "producto": { ... datos actualizados ... }
     * }
     * 
     * Posibles errores:
     * - 400 Bad Request: JSON inválido
     * - 404 Not Found: Producto o categoría no encontrada
     * - 401 Unauthorized: Usuario no autenticado (si está activada la autenticación)
     * 
     * @param Producto $producto - Producto a actualizar (cargado automáticamente)
     * @param Request $request - Objeto con los datos de la petición
     * @param EntityManagerInterface $entityManager - Gestor de entidades de Doctrine
     * @param CategoriaRepository $categoriaRepository - Repositorio para buscar categorías
     * @return JsonResponse - Respuesta con el producto actualizado o mensaje de error
     */
    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Producto $producto,
        Request $request,
        EntityManagerInterface $entityManager,
        CategoriaRepository $categoriaRepository
    ): JsonResponse
    {
        // Verificar que el usuario esté autenticado
        // NOTA: Comentar esta línea si se desactiva autenticación para pruebas
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // Obtener el contenido JSON del body
        $data = json_decode($request->getContent(), true);
        
        // Validar que se envió JSON válido
        if (!$data) {
            return $this->json([
                'error' => 'JSON inválido o vacío'
            ], Response::HTTP_BAD_REQUEST);
        }
        
        // Actualizar solo los campos que fueron enviados en el JSON
        // isset() verifica si la clave existe en el array
        
        // Actualizar nombre si se envió
        if (isset($data['nombre'])) {
            $producto->setNombre($data['nombre']);
        }
        
        // Actualizar precio si se envió
        if (isset($data['precio'])) {
            $producto->setPrecio($data['precio']);
        }
        
        // Actualizar categoría si se envió
        if (isset($data['categoria_id'])) {
            $categoria = $categoriaRepository->find($data['categoria_id']);
            
            // Validar que la categoría existe
            if (!$categoria) {
                return $this->json([
                    'error' => 'Categoría no encontrada'
                ], Response::HTTP_NOT_FOUND);
            }
            
            $producto->setCategoria($categoria);
        }
        
        // Guardar los cambios en la base de datos
        // No necesitamos persist() porque el producto ya existe en la BD
        // flush() ejecuta el UPDATE automáticamente
        $entityManager->flush();
        
        // Retornar el producto actualizado
        return $this->json([
            'mensaje' => 'Producto actualizado exitosamente',
            'producto' => [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'precio' => $producto->getPrecio(),
                'fecha' => $producto->getFecha()->format('Y-m-d'),
                'categoria' => [
                    'id' => $producto->getCategoria()->getId(),
                    'nombre' => $producto->getCategoria()->getNombre(),
                ],
                'usuario' => [
                    'id' => $producto->getUser()->getId(),
                    'email' => $producto->getUser()->getEmail(),
                ]
            ]
        ]);
    }
    
    /**
     * Elimina un producto de la base de datos
     * 
     * Este endpoint permite eliminar permanentemente un producto por su ID.
     * La eliminación es física (no soft delete).
     * 
     * Endpoint: DELETE /api/producto/{id}
     * 
     * Parámetros de ruta:
     * - id (int): ID del producto a eliminar
     * 
     * Respuesta exitosa (200 OK):
     * {
     *   "mensaje": "Producto eliminado exitosamente",
     *   "id": 5
     * }
     * 
     * Posibles errores:
     * - 404 Not Found: El producto no existe
     * - 401 Unauthorized: Usuario no autenticado (si está activada la autenticación)
     * 
     * NOTA: Esta operación es irreversible. En aplicaciones de producción
     * se recomienda implementar soft delete (marcar como inactivo en lugar de eliminar).
     * 
     * @param Producto $producto - Producto a eliminar (cargado automáticamente)
     * @param EntityManagerInterface $entityManager - Gestor de entidades de Doctrine
     * @return JsonResponse - Confirmación de eliminación o mensaje de error
     */
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(
        Producto $producto,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        // NOTA: Autenticación desactivada para facilitar pruebas educativas
        // En producción, descomentar la siguiente línea:
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // Marcar el producto para eliminación
        // remove() NO elimina inmediatamente de la BD
        $entityManager->remove($producto);
        
        // Ejecutar la eliminación física en la base de datos
        // flush() ejecuta el DELETE en la BD
        $entityManager->flush();
        
        // Retornar confirmación de eliminación exitosa
        return $this->json([
            'mensaje' => 'Producto eliminado exitosamente',
            'id' => $producto->getId()
        ]);
    }
}
