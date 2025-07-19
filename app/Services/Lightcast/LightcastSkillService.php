<?php
namespace App\Services\Lightcast;

use Illuminate\Database\Eloquent\Collection;

interface LightcastSkillService
{
    /**
     * Search for skills using the Lightcast API.
     *
     * @param string $searchTerm The term to search for.
     * @param bool $storeToDB Whether to store the results in the database.
     * @return SkillCollection A collection of skills that match the search term.
     * @throws \Exception If the search term is empty or authentication fails.
     */
    public function searchSkill(string $searchTerm): SkillCollection;
}
