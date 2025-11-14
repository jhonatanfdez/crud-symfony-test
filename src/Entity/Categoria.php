<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidad Categoría
 * 
 * Representa una categoría de productos en el sistema.
 * Una categoría puede tener múltiples productos asociados (relación OneToMany).
 * 
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
class Categoria
{
    /**
     * ID único de la categoría (clave primaria)
     * 
     * Se genera automáticamente al insertar un nuevo registro.
     * 
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Nombre de la categoría
     * 
     * Máximo 255 caracteres.
     * Ejemplo: "Electrónica", "Ropa", "Alimentos"
     * 
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * Colección de productos asociados a esta categoría
     * 
     * Relación OneToMany: Una categoría tiene muchos productos.
     * El lado inverso está en Producto::$categoria (ManyToOne).
     * 
     * @var Collection<int, Producto>
     */
    #[ORM\OneToMany(targetEntity: Producto::class, mappedBy: 'categoria')]
    private Collection $productos;

    /**
     * Constructor de la clase
     * 
     * Inicializa la colección de productos como un ArrayCollection vacío.
     * Esto se hace para evitar errores al intentar agregar productos.
     */
    public function __construct()
    {
        $this->productos = new ArrayCollection();
    }

    /**
     * Obtiene el ID de la categoría
     * 
     * @return int|null - ID de la categoría o null si aún no se ha guardado
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtiene el nombre de la categoría
     * 
     * @return string|null - Nombre de la categoría
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * Establece el nombre de la categoría
     * 
     * @param string $nombre - Nuevo nombre para la categoría
     * @return static - Retorna la instancia actual para encadenamiento de métodos
     */
    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Obtiene todos los productos asociados a esta categoría
     * 
     * @return Collection<int, Producto> - Colección de objetos Producto
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    /**
     * Agrega un producto a esta categoría
     * 
     * Si el producto ya existe en la colección, no lo agrega de nuevo.
     * También establece la categoría del producto a esta instancia.
     * 
     * @param Producto $producto - El producto a agregar
     * @return static - Retorna la instancia actual para encadenamiento de métodos
     */
    public function addProducto(Producto $producto): static
    {
        // Verificar si el producto NO está ya en la colección
        if (!$this->productos->contains($producto)) {
            // Agregar el producto a la colección
            $this->productos->add($producto);
            
            // Establecer esta categoría en el producto (mantener sincronización bidireccional)
            $producto->setCategoria($this);
        }

        return $this;
    }

    /**
     * Elimina un producto de esta categoría
     * 
     * Si el producto está en la colección, lo elimina.
     * También desvincula la categoría del producto.
     * 
     * @param Producto $producto - El producto a eliminar
     * @return static - Retorna la instancia actual para encadenamiento de métodos
     */
    public function removeProducto(Producto $producto): static
    {
        // Intentar eliminar el producto de la colección
        if ($this->productos->removeElement($producto)) {
            // Si la categoría del producto es esta instancia, ponerla en null
            // (solo si no fue cambiada por otro código)
            if ($producto->getCategoria() === $this) {
                $producto->setCategoria(null);
            }
        }

        return $this;
    }
}
