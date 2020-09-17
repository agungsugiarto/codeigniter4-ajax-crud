<?php

namespace App\Controllers;

/**
 * Class BaseController.
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

use App\Transformers\BaseTransformer;
use App\Transformers\CodeIgniterPaginatorAdapter;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use League\Fractal\Serializer\JsonApiSerializer;
use Spatie\Fractalistic\Fractal;

class BaseController extends Controller
{
    use ResponseTrait;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // $this->session = \Config\Services::session();
    }

    /**
     * @param mixed                                             $data
     * @param string|callable|\App\Transformers\BaseTransformer $transformer
     *
     * @return \Spatie\Fractal\Fractal
     */
    public function fractalCollection($data, BaseTransformer $transformer)
    {
        $fractal = Fractal::create($data['data'], $transformer, JsonApiSerializer::class)
            ->withResourceName($transformer->getResourceKey())
            ->paginateWith(new CodeIgniterPaginatorAdapter($data['paginate']));

        return $this->respond($fractal);
    }

    /**
     * @param mixed                                             $data
     * @param string|callable|\App\Transformers\BaseTransformer $transformer
     *
     * @return \Spatie\Fractal\Fractal
     */
    public function fractalItem($data, BaseTransformer $transformer)
    {
        $fractal = Fractal::create($data, $transformer, JsonApiSerializer::class)
            ->withResourceName($transformer->getResourceKey());

        return $this->respond($fractal);
    }
}
