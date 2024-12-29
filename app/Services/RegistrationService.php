<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Interfaces\RegistrationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
    protected $registrationRepository;
    protected $departmentService;
    protected $departmentRequirementService;
    protected $userService;
    protected $studentService;
    protected $registrationGradeService;

    public function __construct(
        RegistrationRepositoryInterface $registrationRepository,
        DepartmentService $departmentService,
        DepartmentRequirementService $departmentRequirementService,
        UserService $userService,
        StudentService $studentService,
        RegistrationGradeService $registrationGradeService
    ) {
        $this->registrationRepository = $registrationRepository;
        $this->departmentService = $departmentService;
        $this->departmentRequirementService = $departmentRequirementService;
        $this->userService = $userService;
        $this->studentService = $studentService;
        $this->registrationGradeService = $registrationGradeService;
    }

    public function getAll()
    {
        return $this->registrationRepository->getAll();
    }

    public function getPaginate(Request $request)
    {
        return $this->registrationRepository->getPaginate($request->all());
    }

    public function getById($id)
    {
        return $this->registrationRepository->getById($id);
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->validated();

            // Validate Grade
            $this->departmentRequirementService->validateGrades($input['grades'], $input['department_id']);

            // Check Registration Quota
            $this->departmentService->checkRegistrationQuoat($input['department_id']);

            $user = $this->userService->create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'status' => 'active',
            ]);

            $student = $this->studentService->create([
                'user_id' => $user->id,
                'phone' => $input['phone'],
                'zip_code' => $input['zip_code'],
                'address' => $input['address'],
                'date_of_birth' => $input['date_of_birth'],
                'place_of_birth' => $input['place_of_birth'],
            ]);

            $registration = $this->registrationRepository->create([
                'department_id' => $input['department_id'],
                'student_id' => $student->id,
                'status' => 'approved',
            ]);

            $this->registrationGradeService->createByRegistrationId($input['grades'], $registration->id);

            DB::commit();
            return $registration;
        } catch (\Exception $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update($id, Request $request)
    {
        try {
            $input = $request->validated();
            return $this->registrationRepository->update($id, $input);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        return $this->registrationRepository->delete($id);
    }
}
