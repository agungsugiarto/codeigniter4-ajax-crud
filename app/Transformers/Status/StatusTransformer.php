<?php

namespace App\Transformers\Status;

use App\Transformers\BaseTransformer;

class StatusTransformer extends BaseTransformer
{
    public function getResourceKey(): string
    {
        return 'status';
    }

    public function transform($status)
    {
        return [
            'id'         => $status->id,
            'status'     => $status->status,
            'created_at' => $status->created_at,
            'updated_at' => $status->updated_at,
        ];
    }
}
