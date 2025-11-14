<?php

namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Producto>
 */
class ProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    /**
     * Busca productos por nombre
     * 
     * Este método permite buscar productos cuyo nombre contenga el término de búsqueda.
     * Usa LIKE con % para buscar coincidencias parciales (no necesita ser exacto).
     * 
     * @param string|null $searchTerm - El término de búsqueda (puede ser null o vacío)
     * @return Producto[] - Retorna un array de objetos Producto que coinciden
     */
    public function findByNombre(?string $searchTerm): array
    {
        // Crear un QueryBuilder para construir la consulta SQL
        // 'p' es el alias que usamos para referirnos a la entidad Producto
        $qb = $this->createQueryBuilder('p');
        
        // Verificar si hay un término de búsqueda
        // Si searchTerm no está vacío, agregamos la condición WHERE
        if ($searchTerm) {
            $qb
                // WHERE p.nombre LIKE :searchTerm
                // Busca productos cuyo nombre contenga el término
                ->andWhere('p.nombre LIKE :searchTerm')
                
                // Reemplazar :searchTerm con el valor real
                // El % antes y después permite buscar en cualquier parte del nombre
                // Ejemplo: si buscas "mouse", encontrará "Mouse Gamer", "Mouse Inalámbrico", etc.
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
        
        // Ordenar los resultados por nombre de forma ascendente (A-Z)
        $qb->orderBy('p.nombre', 'ASC');
        
        // Ejecutar la consulta y obtener los resultados
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Producto[] Returns an array of Producto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Producto
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
