<?php

namespace App\Services;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Collection;

class SkillService
{
    public function getAllSkills(): Collection
    {
        return Skill::orderBy('order', 'asc')->get();
    }

    public function createSkill(array $data): Skill
    {
        return Skill::create($data);
    }

    public function updateSkill(Skill $skill, array $data): bool
    {
        return $skill->update($data);
    }

    public function deleteSkill(Skill $skill): bool
    {
        return $skill->delete();
    }
}
