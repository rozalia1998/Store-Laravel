<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use Carbon\Carbon;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $timepassed=$this->created_at->diffForHumans();

        return [
            'username'=>$this->user->name,
            'rate'=>$this->rate,
            'comment'=>$this->comment,
            'added_since'=>$timepassed
        ];
    }
}
