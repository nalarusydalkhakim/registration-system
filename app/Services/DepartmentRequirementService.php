<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Interfaces\DepartmentRequirementRepositoryInterface;
use Illuminate\Http\Request;

class DepartmentRequirementService
{
    protected $departmentRequirementRepository;

    public function __construct(DepartmentRequirementRepositoryInterface $departmentRequirementRepository)
    {
        $this->departmentRequirementRepository = $departmentRequirementRepository;
    }

    public function getAll()
    {
        return $this->departmentRequirementRepository->getAll();
    }

    public function getPaginate(Request $request)
    {
        return $this->departmentRequirementRepository->getPaginate($request->all());
    }

    public function getById($id)
    {
        return $this->departmentRequirementRepository->getById($id);
    }

    public function create(Request $request)
    {
        try {
            $input = $request->validated();
            return $this->departmentRequirementRepository->create($input);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function update($id, Request $request)
    {

        try {
            $input = $request->validated();
            return $this->departmentRequirementRepository->update($id, $input);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        return $this->departmentRequirementRepository->delete($id);
    }

    public function validateGrades(array $grades, string $id)
    {
        $departmentRequirements = $this->departmentRequirementRepository->getByDepartmentId($id);

        if ($departmentRequirements->isEmpty()) {
            throw new CustomException("Department dengan ID {$id} tidak memiliki persyaratan kursus.", 422);
        }

        $requirementsByCourseId = $departmentRequirements->keyBy('course_id');

        foreach ($grades as $grade) {
            if (!isset($requirementsByCourseId[$grade['course_id']])) {
                throw new CustomException("Persyaratan Mata Pelajaran {$requirementsByCourseId[$grade['course_id']]['course']->name}  tidak valid untuk department ini.", 422);
            }

            $minimumGrade = $requirementsByCourseId[$grade['course_id']]['minimum_grade'];

            if ($grade['grade'] < $minimumGrade) {
                throw new CustomException("Grade untuk Mata Pelajaran {$requirementsByCourseId[$grade['course_id']]['course']->name} harus lebih besar atau sama dengan {$minimumGrade} pada {$requirementsByCourseId[$grade['course_id']]['department']->name}", 422);
            }
        }
    }
}
