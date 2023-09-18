<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

if (!function_exists('fileUrl')) {

    /**
     * Generate the URL file for api
     *
     * @param string|null $storedFile
     *
     * @return string|null
     */
    function fileUrl($storedFile): null|string
    {
        return is_null($storedFile) ? null : asset('storage/' . Str::replace('public/', '', $storedFile));
    }
}

if (!function_exists('requireRouteFiles')) {

    /**
     * Require the files
     *
     * @param string $folder
     *
     * @return void
     */
    function requireRouteFiles(string $folder)
    {
        $dirIterator = new RecursiveDirectoryIterator($folder);

        /** @var RecursiveDirectoryIterator|RecursiveIteratorIterator $iterator : directory iterator*/
        $iterator = new RecursiveIteratorIterator($dirIterator);

        while ($iterator->valid()) {
            if (
                !$iterator->isDot()
                && $iterator->isFile()
                && $iterator->isReadable()
                && $iterator->getExtension() == 'php'
            ) {
                require $iterator->key();
            }

            $iterator->next();
        }
    }
}

if (!function_exists('addFullTextSearchIndex')) {

    /**
     * Add trgm fulltext search index on a table
     *
     * @param string $table
     * @param array $columns
     *
     * @return void
     */
    function addFullTextSearchIndex(string $table, array $columns)
    {
        if (config('database.default') === 'pgsql') {
            $columnsToTrack = implode(" || ' ' || ", $columns);
            DB::statement("CREATE INDEX idx_fulltext_$table ON
            $table USING gin(to_tsvector('french', $columnsToTrack))");
        }

        if (config('database.default') === "mysql") {
            $imploded = implode(", ", $columns);
            DB::statement("CREATE FULLTEXT INDEX idx_fulltext_$table ON $table($imploded)");
        }
    }
 }

if (!function_exists('generateCode')) {

    /**
     * Format the number
     *
     * @return string
     */
    function generateCode(string $prefix = ""): string
    {
        return  "$prefix" . strtoupper(Str::random(2)) . now()->format('ymds');
    }
}

if (!function_exists('arrayAddBetween')) {

    /**
     * add values between
     *
     * @return string
     */
    function arrayAddBetween(array $attributes, string $element = ' '): array
    {
        $touputArray = [];

        array_map(function ($item) use (&$touputArray, $element) {
            $touputArray[] = $item;
            $touputArray[] = $element;
        }, $attributes);

        return array_pop($touputArray);
    }
}
