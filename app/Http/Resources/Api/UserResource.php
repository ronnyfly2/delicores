<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

use Hashids;
use Carbon\Carbon;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $data = [
            '_id' => (string) Hashids::encode($this->id),
            'name' => (string) $this->name,
            'email' => (string) $this->email,
            'document_type' => (string) $this->document_type,
            'document_number' => (string) $this->document_number,
            'phone' => (string) $this->phone,
            'birthdate' => $this->birthdate->format('d/m/Y'),
        ];

        if(isset($this->bearer_token))
            $data['auth'] = [
                'access_token' => $this->bearer_token,
                'type' => 'bearer',
            ];

        return $data;
    }
}
