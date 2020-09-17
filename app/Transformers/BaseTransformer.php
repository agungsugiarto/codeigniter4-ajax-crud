<?php

namespace App\Transformers;

use App\Traits\HashableTrait;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    use HashableTrait;

    /**
     * Resource key name.
     *
     * @return string
     */
    abstract public function getResourceKey(): string;

    /**
     * Create a new collection resource object.
     *
     * @param mixed                        $data
     * @param TransformerAbstract|callable $transformer
     * @param string                       $resourceKey
     *
     * @return Collection
     */
    protected function collection($data, $transformer, $resourceKey = null)
    {
        return parent::collection($data, $transformer, $resourceKey ?: $transformer->getResourceKey());
    }
}
