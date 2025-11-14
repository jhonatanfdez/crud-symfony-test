<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidad Producto
 * 
 * Representa un producto en el sistema de gestión.
 * Cada producto pertenece a una categoría y está asignado a un usuario.
 * La fecha de creación se establece automáticamente al crear un nuevo producto.
 * 
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: ProductoRepository::class)]
#[ORM\HasLifecycleCallbacks]  // Habilita los callbacks de ciclo de vida (como PrePersist)
class Producto
{
    /**
     * ID único del producto (clave primaria)
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
     * Nombre del producto
     * 
     * Máximo 255 caracteres.
     * Ejemplo: "Laptop HP Pavilion 15", "Mouse Logitech MX Master"
     * 
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * Precio del producto
     * 
     * Almacenado como DECIMAL en la base de datos.
     * Precision 10: hasta 10 dígitos en total
     * Scale 2: 2 decimales (centavos)
     * Ejemplo: 1234.56 (4 dígitos antes del punto, 2 después)
     * Máximo: 99,999,999.99
     * 
     * @var string|null - Se usa string para mantener precisión decimal exacta
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $precio = null;

    /**
     * Fecha y hora de creación del producto
     * 
     * Se establece automáticamente al crear el producto gracias al método
     * setFechaAutomatica() que se ejecuta antes de guardar (PrePersist).
     * 
     * DATETIME_MUTABLE: Permite modificar el objeto DateTime directamente.
     * DateTimeInterface: Interfaz que acepta DateTime o DateTimeImmutable.
     * 
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;
    
    /**
     * Categoría a la que pertenece el producto
     * 
     * Relación ManyToOne: Muchos productos pertenecen a una categoría.
     * El lado inverso está en Categoria::$productos (OneToMany).
     * nullable: false - No puede ser null (siempre debe tener una categoría)
     * 
     * @var Categoria|null
     */
    #[ORM\ManyToOne(inversedBy: 'productos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categoria $categoria = null;

    /**
     * Usuario responsable del producto
     * 
     * Relación ManyToOne: Muchos productos pertenecen a un usuario.
     * El lado inverso está en User::$productos (OneToMany).
     * nullable: false - No puede ser null (siempre debe tener un usuario asignado)
     * 
     * @var User|null
     */
    #[ORM\ManyToOne(inversedBy: 'productos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * Obtiene el ID del producto
     * 
     * @return int|null - ID del producto o null si aún no se ha guardado
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtiene el nombre del producto
     * 
     * @return string|null - Nombre del producto
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * Establece el nombre del producto
     * 
     * @param string $nombre - Nuevo nombre para el producto
     * @return static - Retorna la instancia actual para encadenamiento de métodos
     */
    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Obtiene el precio del producto
     * 
     * @return string|null - Precio como string para mantener precisión decimal
     */
    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    /**
     * Establece el precio del producto
     * 
     * @param string $precio - Nuevo precio (formato: "1234.56")
     * @return static - Retorna la instancia actual para encadenamiento de métodos
     */
    public function setPrecio(string $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Obtiene la fecha de creación del producto
     * 
     * @return \DateTime|null - Fecha y hora de creación
     */
    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    /**
     * Establece la fecha de creación del producto
     * 
     * Normalmente no se llama directamente, se usa setFechaAutomatica()
     * 
     * @param \DateTime $fecha - Nueva fecha de creación
     * @return static - Retorna la instancia actual para encadenamiento de métodos
     */
    public function setFecha(\DateTime $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Obtiene la categoría del producto
     * 
     * @return Categoria|null - Categoría asociada al producto
     */
    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    /**
     * Establece la categoría del producto
     * 
     * @param Categoria|null $categoria - Nueva categoría para el producto
     * @return static - Retorna la instancia actual para encadenamiento de métodos
     */
    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Obtiene el usuario responsable del producto
     * 
     * @return User|null - Usuario asignado al producto
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Establece el usuario responsable del producto
     * 
     * @param User|null $user - Nuevo usuario responsable
     * @return static - Retorna la instancia actual para encadenamiento de métodos
     */
    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Establece automáticamente la fecha de creación
     * 
     * Este método se ejecuta automáticamente ANTES de insertar el producto
     * en la base de datos (evento PrePersist de Doctrine).
     * 
     * Si la fecha aún no está establecida (es null), la asigna con la fecha
     * y hora actual. Esto evita que tengamos que establecerla manualmente
     * cada vez que creamos un producto.
     * 
     * @return void
     */
    #[ORM\PrePersist]
    public function setFechaAutomatica(): void
    {
        // Solo establecer la fecha si aún no tiene una (al crear)
        if ($this->fecha === null) {
            $this->fecha = new \DateTime();  // Fecha y hora actual
        }
    }
}
