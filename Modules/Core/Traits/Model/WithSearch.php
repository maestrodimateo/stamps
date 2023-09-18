<?php
namespace Modules\Core\Traits\Model;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait allowing simple and full text search
 * * Don't forget to use the $fullTextColumns attribute in your model to define
 * * which columns will be taken into account during the full text search
 */
trait WithSearch
{

    private string $search = '';

    /**
     * Get the right operation according to the database type
     *
     * @return array
     */
    private function getOperation(): array
    {
        return [
            'pgsql' => [
                'operator' => 'ilike',
                'query' => fn () => $this->generateQueryForPostgresql(),
                'more' => []
            ],
            'mysql' => [
                'operator' => 'like',
                'query' => fn () => $this->generateQueryForMysql(),
                'more' => ["*{$this->search}*"]
            ]
        ];
    }

    /**
     * Simple search with "like"
     *
     * @param Builder $query
     * @param string $attribute
     * @param string $search
     *
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $attribute, string $search = null): Builder
    {
        $operator = $this->getOperation()[config('database.default')]['operator'];

        return $query->where($attribute, $operator, "%$search%");
    }

    /**
     * Search through multiple attributes
     *
     * @param Builder $query
     * @param array $attributes
     * @param string $search;
     *
     * @return Builder
     */
    public function scopeFullTextSearch(Builder $query, string $search = null): Builder
    {
        if (!$this->fullTextColumns) {
            throw new \Exception("The fullTextColumns attribute does not exist in ". self::class, 1);
        }

        $this->setSearch($search);

        $sqlQuery = $this->generateQuery();

        $parameters = $this->getOperation()[config('database.default')]['more'];

        return $query->whereRaw($sqlQuery, $parameters);
    }

    /**
     * Generate the fulltext search query
     *
     * @param array $attributes
     * @return string
     */
    private function generateQuery(): string
    {
        return $this->getOperation()[config('database.default')]['query']();
    }

    /**
     * Generate the full text search query for postgreSQL
     *
     * @param array $attributes
     *
     * @return string
     */
    private function generateQueryForPostgresql(): string
    {
        $columnsToTrack = implode(" || ' ' || ", $this->fullTextColumns);

        return "to_tsvector('french', $columnsToTrack) @@ phraseto_tsquery('french', '{$this->search}')";
    }

    /**
     * Generate the full text search query for postgreSQL
     *
     * @param array $attributes
     *
     * @return string
     */
    private function generateQueryForMysql(): string
    {
        $fullTextColumns = implode(', ', $this->fullTextColumns);

        return "MATCH($fullTextColumns) AGAINST(? IN BOOLEAN MODE)";
    }

    /**
     * Set search
     *
     * @param string $search
     *
     * @return void
     */
    private function setSearch(string $search): void
    {
        $this->search = htmlspecialchars($search);
    }
}
