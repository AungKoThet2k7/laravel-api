<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function stockStatus($count){
            $status = "";
            if($count>10){
                $status = "available";
            }elseif($count>0){
                $status = "few";
            }elseif($count===0){
                $status = "unavailable";
            }

            return $status;
        }

    public function toArray($request)
    {


        return [
            "id" => $this->id,
            "name" =>$this->name,
            "price" => $this->price,
            "show_price" => $this->price. " MMK",
            "stock" => $this->stock,
            "stock_status" => $this->stockStatus($this->stock),
            "date" => $this->created_at->format("j M Y"),
            "time" => $this->created_at->format("G: i A"),
            "owner" => new UserResource($this->user),
            "photos" => PhotoResource::collection($this->photos),
        ];
    }
}
