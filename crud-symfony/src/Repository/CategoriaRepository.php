<?php

namespace App\Repository;

use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categoria>
 */
class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    /**
     * Busca categorías por nombre
     * 
     * Este método permite buscar categorías cuyo nombre contenga el término de búsqueda.
     * Usa LIKE con % para buscar coincidencias parciales (no necesita ser exacto).
     * 
     * @param string|null $searchTerm - El término de búsqueda (puede ser null o vacío)
     * @return Categoria[] - Retorna un array de objetos Categoria que coinciden
     */
    public function findByNombre(?string $searchTerm): array
    {
        // Crear un QueryBuilder para construir la consulta SQL
        // 'c' es el alias que usamos para referirnos a la entidad Categoria
        $qb = $this->createQueryBuilder('c');
        
        // Verificar si hay un término de búsqueda
        // Si searchTerm no está vacío, agregamos la condición WHERE
        if ($searchTerm) {
            $qb
                // WHERE c.nombre LIKE :searchTerm
                // Busca categorías cuyo nombre contenga el término
                ->andWhere('c.nombre LIKE :searchTerm')
                
                // Reemplazar :searchTerm con el valor real
                // El % antes y después permite buscar en cualquier parte del nombre
                // Ejemplo: si buscas "lap", encontrará "Laptops", "Laptop Gaming", etc.
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
        
        // Ordenar los resultados por nombre de forma ascendente (A-Z)
        $qb->orderBy('c.nombre', 'ASC');
        
        // Ejecutar la consulta y obtener los resultados
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Categoria[] Returns an array of Categoria objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Categoria
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
