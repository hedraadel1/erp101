<?php

namespace Modules\Connector\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProdResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $all_data = parent::toArray($request);
        $array = parent::toArray($request);

        $array = [
            'id' => $array['id'],
            'name' => $array['name'],
            'sku' => $array['sku'],
            'barcode_type' => $array['barcode_type'],
        ];

        return $array;
    }
}
