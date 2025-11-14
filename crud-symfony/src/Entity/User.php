<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Entidad User (Usuario)
 * 
 * Representa un usuario del sistema con capacidades de autenticación.
 * Implementa las interfaces de Symfony para manejo de seguridad y contraseñas.
 * Cada usuario puede tener múltiples productos asignados.
 * 
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]  // Backticks porque 'user' es palabra reservada en SQL
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]  // Índice único en email
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]  // Validación
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * ID único del usuario (clave primaria)
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
     * Email del usuario (identificador único)
     * 
     * Se usa como username para iniciar sesión.
     * Debe ser único en toda la base de datos.
     * Máximo 180 caracteres.
     * 
     * @var string|null
     */
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * Roles del usuario
     * 
     * Array de strings con los roles asignados.
     * Por defecto, todos los usuarios tienen ROLE_USER.
     * Ejemplos: ['ROLE_USER'], ['ROLE_ADMIN'], ['ROLE_USER', 'ROLE_EDITOR']
     * 
     * @var list<string>
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * Contraseña hasheada del usuario
     * 
     * NUNCA se almacena en texto plano.
     * Se hashea usando el algoritmo configurado en security.yaml
     * (por defecto: bcrypt o argon2i)
     * 
     * @var string|null
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * Colección de productos asociados a este usuario
     * 
     * Relación OneToMany: Un usuario puede tener muchos productos.
     * El lado inverso está en Producto::$user (ManyToOne).
     * 
     * @var Collection<int, Producto>
     */
    #[ORM\OneToMany(targetEntity: Producto::class, mappedBy: 'user')]
    private Collection $productos;

    /**
     * Constructor de la clase
     * 
     * Inicializa la colección de productos como un ArrayCollection vacío.
     */
    public function __construct()
    {
        $this->productos = new ArrayCollection();
    }

    /**
     * Obtiene el ID del usuario
     * 
     * @return int|null - ID del usuario o null si aún no se ha guardado
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtiene el email del usuario
     * 
     * @return string|null - Email del usuario
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Establece el email del usuario
     * 
     * @param string $email - Nuevo email
     * @return static - Retorna la instancia actual para encadenamiento
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Identificador visual del usuario
     * 
     * Método requerido por UserInterface.
     * Retorna el email como identificador del usuario.
     * Se usa en los logs y mensajes de error.
     * 
     * @see UserInterface
     * @return string - Email del usuario
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * Obtiene los roles del usuario
     * 
     * Método requerido por UserInterface.
     * Siempre retorna al menos ROLE_USER.
     * Los roles duplicados se eliminan automáticamente.
     * 
     * @see UserInterface
     * @return array - Array de roles (ej: ['ROLE_USER', 'ROLE_ADMIN'])
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        
        // Garantizar que todo usuario tenga al menos ROLE_USER
        $roles[] = 'ROLE_USER';

        // Eliminar roles duplicados
        return array_unique($roles);
    }

    /**
     * Establece los roles del usuario
     * 
     * @param list<string> $roles - Array de roles a asignar
     * @return static - Retorna la instancia actual para encadenamiento
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Obtiene la contraseña hasheada
     * 
     * Método requerido por PasswordAuthenticatedUserInterface.
     * Retorna el hash de la contraseña, NUNCA la contraseña en texto plano.
     * 
     * @see PasswordAuthenticatedUserInterface
     * @return string|null - Hash de la contraseña
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Establece la contraseña hasheada
     * 
     * IMPORTANTE: Debe recibir la contraseña YA hasheada.
     * No hashear aquí, usar UserPasswordHasher en el controlador.
     * 
     * @param string $password - Contraseña hasheada
     * @return static - Retorna la instancia actual para encadenamiento
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Borra credenciales sensibles
     * 
     * Método requerido por UserInterface.
     * Se usa para limpiar datos temporales después de la autenticación.
     * Por ejemplo, si guardamos la contraseña en texto plano temporalmente,
     * aquí la borraríamos.
     * 
     * @deprecated Se eliminará en Symfony 8
     * @return void
     */
    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // No almacenamos contraseñas en texto plano, no hay nada que borrar
    }

    /**
     * Obtiene todos los productos asociados a este usuario
     * 
     * @return Collection<int, Producto> - Colección de objetos Producto
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    /**
     * Agrega un producto a este usuario
     * 
     * Si el producto ya existe en la colección, no lo agrega de nuevo.
     * También establece el usuario del producto a esta instancia.
     * 
     * @param Producto $producto - El producto a agregar
     * @return static - Retorna la instancia actual para encadenamiento
     */
    public function addProducto(Producto $producto): static
    {
        // Verificar si el producto NO está ya en la colección
        if (!$this->productos->contains($producto)) {
            // Agregar el producto a la colección
            $this->productos->add($producto);
            
            // Establecer este usuario en el producto (sincronización bidireccional)
            $producto->setUser($this);
        }

        return $this;
    }

    /**
     * Elimina un producto de este usuario
     * 
     * Si el producto está en la colección, lo elimina.
     * También desvincula el usuario del producto.
     * 
     * @param Producto $producto - El producto a eliminar
     * @return static - Retorna la instancia actual para encadenamiento
     */
    public function removeProducto(Producto $producto): static
    {
        // Intentar eliminar el producto de la colección
        if ($this->productos->removeElement($producto)) {
            // Si el usuario del producto es esta instancia, ponerlo en null
            // (solo si no fue cambiado por otro código)
            if ($producto->getUser() === $this) {
                $producto->setUser(null);
            }
        }

        return $this;
    }
}
