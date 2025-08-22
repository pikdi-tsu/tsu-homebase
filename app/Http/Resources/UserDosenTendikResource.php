<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDosenTendikResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'nik' => $this->nik,
            'nama' => $this->name,
            'email' => $this->email,
            'q1' => $this->q1,
            'a1' => $this->a1,
            'q2' => $this->q2,
            'a2' => $this->a2,
            'is_active' => $this->is_active,
        ];
    }
}
