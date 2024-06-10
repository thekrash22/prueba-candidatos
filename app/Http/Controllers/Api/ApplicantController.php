<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicantStoreRequest;
use App\Http\Resources\ApplicantResource;
use App\Interfaces\ApplicantRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class ApplicantController extends Controller
{
    private $applicantRepository;
    public function  __construct(ApplicantRepositoryInterface $applicantRepository)
    {
        $this->applicantRepository = $applicantRepository;
    }


    public function index()
    {
        try {
            $applicants = $this->applicantRepository->getAll();
            return ApiResponseHelper::successResponse(ApplicantResource::collection($applicants), Response::HTTP_OK);
        }catch (UnauthorizedException $exception){
            return ApiResponseHelper::errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
        }
        catch (\Exception $exception){
            return ApiResponseHelper::errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function store(ApplicantStoreRequest $request)
    {
        try {
            $applicant = $this->applicantRepository->save($request->all());
            return ApiResponseHelper::successResponse(new ApplicantResource($applicant), Response::HTTP_CREATED);
        }catch (\Exception $exception){
            return ApiResponseHelper::errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $applicant = $this->applicantRepository->getById($id);
            return ApiResponseHelper::successResponse(new ApplicantResource($applicant), Response::HTTP_OK);
        }catch (\Exception $exception){
            return ApiResponseHelper::errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
