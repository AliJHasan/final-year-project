<?php

namespace App\Http\Resources;

use App\Models\ResultScientific;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class return_final extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'subscriptionNumber' => $this->subscriptionNumber,
            'totalSum' => $this->totalSum,
            'state'=> $this->state,
            'fullname'=> $get = DB::table('users')->where('subscriptionNumber',$this->subscriptionNumber)->value('fullName')
        ];
    }
}
