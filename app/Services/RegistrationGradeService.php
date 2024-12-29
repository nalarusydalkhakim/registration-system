<?php

namespace App\Services;

use App\Interfaces\RegistrationGradeRepositoryInterface;
use Illuminate\Http\Request;

class RegistrationGradeService
{
    protected $registrationGradeRepository;

    public function __construct(RegistrationGradeRepositoryInterface $registrationGradeRepository)
    {
        $this->registrationGradeRepository = $registrationGradeRepository;
    }

    public function getAll()
    {
        return $this->registrationGradeRepository->getAll();
    }

    public function createByRegistrationId(array $data, string $registrationId)
    {
        try {

            $data = array_map(function ($data) use ($registrationId) {
                return [
                    'registration_id' => $registrationId,
                    'course_id' => $data['course_id'],
                    'grade' => $data['grade'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data);

            return $this->registrationGradeRepository->bulkInsert($data);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        return $this->registrationGradeRepository->delete($id);
    }
}
