<?php

namespace App\Http\Resources\Links;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Examples(example="LinkCollection", 
 *      summary="Data Content",
 *      value={
 *          "status": "success", "code": 200,  
 *          "data": {
 *              {
 *                  "id": "bb804f46-8a73-4ad6-bf8a-d3cbde59a7e7",
 *                  "url": "http://christiansen.org/aut-natus-minus-labore",
 *                  "short_url": "https://xyz.ex/w6FG22",
 *                  "created_at": "2022-09-11T23:46:38.000000Z",
 *                  "updated_at": "2022-09-11T23:46:38.000000Z",
 *              }
 *          }
 *      }
 * ),
 */
class LinkCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
