<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
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
            'id' => $this->id,
            'owner' => MerchantResource::make($this->whenLoaded('merchant')),
            'store_name' => $this->store_name,
            'permit' => $this->permit,
            'building_number' => $this->building_number,
            'street' => $this->street,
            'city' => $this->city,
            'landline' => $this->landline,
            'mobile' => $this->mobile,
            'social_link' => $this->social_link
        ];
    }
}
