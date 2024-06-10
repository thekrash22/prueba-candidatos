<?php

namespace App\Repositories;


use App\Interfaces\ApplicantRepositoryInterface;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ApplicantRepository extends BaseRepository implements ApplicantRepositoryInterface
{
    public function __construct(Applicant $applicant)
    {
        parent::__construct($applicant);
        $this->model = $applicant;
    }
    public function save(array $data){
        $data['created_by'] = auth()->id();
        return parent::save($data);
    }

    public function getById($id)
    {
        $record = $this->model->find($id);
        if(!$record){
            throw new ModelNotFoundException("No lead found");
        }
        if ((auth()->user()->hasPermissionTo('get_applicant')) || auth()->user()->hasPermissionTo('get_my-applicant') && $record->owner == auth()->id()) {
            return $record;
        }else{
            throw new UnauthorizedException(403, 'You are not authorized to view this.');
        }

    }

    public function getAll()
    {
        if(auth()->user()->hasPermissionTo('list_applicants')){
            return parent::getAll();
        }
        elseif (auth()->user()->hasPermissionTo('list_my-applicants')){
            return $this->model->where('owner', auth()->id())->orderBy('name')->get();
        }
        else{
            throw new UnauthorizedException(403, 'You are not authorized to view this.');
        }
    }

}
