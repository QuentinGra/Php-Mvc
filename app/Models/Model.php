<?php

namespace App\Models;

use App\Core\Db;
use PDOStatement;

abstract class Model extends Db
{
    public function __construct(
        protected ?string $table = null,
        protected ?Db $db = null,
    ) {
    }

    /**
     * Find all data in one table
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->fetchHydrate(
            $this->runQuery("SELECT * FROM $this->table")->fetchAll()
        );
    }

    /**
     * Find one data in table filter by id
     *
     * @param integer $id
     * @return boolean|static
     */
    public function find(int $id): bool|static
    {
        return $this->fetchHydrate(
            $this->runQuery("SELECT * FROM $this->table WHERE id = :id", [
                'id' => $id,
            ])->fetch()
        );
    }

    /**
     * Find data in database with dynamic filter
     *
     * @param array $filters
     * @return array
     */
    public function findBy(array $filters): array
    {
        $champs = [];
        $params = [];

        foreach ($filters as $key => $value) {
            $champs[] = "$key = :$key";
            $params[$key] = $value;
        }

        $champStr = implode(' AND ', $champs);

        return $this->fetchHydrate($this->runQuery("SELECT * FROM $this->table WHERE $champStr", $params)->fetchAll());
    }

    /**
     * Find one entry in Db with dynamic filter
     *
     * @param array $filters
     * @return array|boolean
     */
    public function findOneBy(array $filters): array|bool
    {
        $champs = [];
        $params = [];

        foreach ($filters as $key => $value) {
            $champs[] = "$key = :$key";
            $params[$key] = $value;
        }

        $champStr = implode(' AND ', $champs);

        return $this->fetchHydrate($this->runQuery("SELECT * FROM $this->table WHERE $champStr", $params)->fetch());
    }

    /**
     * Create in database
     *
     * @return PDOStatement|boolean
     */
    public function create(): PDOStatement|bool
    {
        $champs = [];
        $markers = [];
        $params = [];

        // On boucle sur l'object pour remplir dynamiquement les tableaux
        foreach ($this as $key => $value) {
            // On vérifie que la valeur n'est pas null et que la propriété
            // N'est pas table (Pas un champ en BDD)
            if ($key !== 'table' && $value !== null) {
                $champs[] = $key;
                $markers[] = ":$key";
                $params[$key] = $value;
            }
        }

        // On transforme les tableaux en chaine de caractère pour les intégrer
        // Dans la requête SQL
        $strChamps = implode(', ', $champs);
        $strMarkers = implode(', ', $markers);

        return $this->runQuery("INSERT INTO $this->table($strChamps) VALUES ($strMarkers)", $params);
    }

    /**
     * Update data in database
     *
     * @return PDOStatement|boolean
     */
    public function update(): PDOStatement|bool
    {
        $champs = [];
        $params = [];

        foreach ($this as $key => $value) {
            if ($key !== 'table' && $key !== 'id' && $value !== null) {
                $champs[] = "$key = :$key";
                $params[$key] = $value;
            }
        }

        $champStr = implode(", ", $champs);

        /** @var User $this */
        $params['id'] = $this->id;

        return $this->runQuery("UPDATE $this->table SET $champStr WHERE id = :id ", $params);
    }

    /**
     * Delete a data from DB
     *
     * @return PDOStatement|boolean
     */
    public function delete(): PDOStatement|bool
    {
        /** @var User $this */
        return $this->runQuery(
            "DELETE FROM $this->table WHERE id= :id",
            ['id' => $this->id]
        );
    }

    /**
     * Méthode d'hydratation d'un objet à partir d'un tableau associatif
     *      $donnees = [
     *          'titre' => "Titre de l'objet",
     *          'description' => 'Desc',
     *          'actif' => true,
     *      ];
     * 
     *      RETOURNE:
     *          $article->setTitre('Titre de l'objet')
     *              ->setDescription('Desc')
     *              ->setActif(true);
     *
     * @param array|object $donnees
     * @return static
     */
    public function hydrate(array|object $data): static
    {
        // On boucle sur le tableau Data
        foreach ($data as $key => $value) {
            // On créé dynamiquement le nom du setter
            $setter = 'set' . ucfirst($key);

            // On vérifie que le setter exist dans l'objet
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }

        return $this;
    }

    /**
     * Méthode pour transformer automatiquement les données transmises par PDO
     * en recherche DB. Transforme un oject (StdClass) en instance de notre model (new User)
     *
     * @param mixed $query
     * @return static|array|boolean
     */
    public function fetchHydrate(mixed $query): static|array|bool
    {
        if (is_array($query) && count($query) > 1) {

            $data = array_map(function (object $object) {
                return (new static)->hydrate($object);
            }, $query);

            return $data;
        } elseif (!empty($query)) {
            return (new static())->hydrate($query);
        } else {
            return $query;
        }
    }

    /**
     * Execute SQL query in database
     *
     * @param string $sql
     * @param array|null $params
     * @return PDOStatement|boolean
     */
    protected function runQuery(string $sql, ?array $params = null): PDOStatement|bool
    {
        $this->db = Db::getInstance();

        if ($params) {
            // Requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($params);
        } else {
            // Requête simple
            $query = $this->db->query($sql);
        }

        return $query;
    }
}
