<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HealthWorkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     'id'    =>  $this->id,
        //     'name'    =>  $this->name,
        //     'user_id'    =>  $this->user_id,
        //     'age'    =>  $this->age,
        //     'gender'    =>  $this->gender,
        //     'cadre'    =>  $this->cadre,
        //     'image'    =>  asset($this->image),
        // ];
    }
}
