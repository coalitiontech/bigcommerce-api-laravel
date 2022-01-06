<?php

namespace CoalitionTech\BigCommerceAPI;

use Illuminate\Support\Facades\Config;

abstract class BigCommerceAPI
{
    protected $endPoint;

    /**
     * @var BigCommerceClient
     */
    public $bigCommerceClient;

    private $base_url;

    private $api_version;

    public function __construct()
    {
        $class_name = Config::get('bigcommerce-api-laravel.big_client', BigCommerceClient::class);
        $this->bigCommerceClient = new $class_name();
    }

    private function getBaseUrl()
    {
        if ($this->base_url)
            return $this->base_url;
        return $this->base_url = Config::get('bigcommerce.base_url');
    }

    private function getApiVersion()
    {
        if ($this->api_version)
            return $this->api_version;
        return $this->api_version = Config::get('bigcommerce.api_version');
    }

    public function generateUrl($end_point, $id = null): string
    {
        return $this->getBaseUrl() . $this->bigCommerceClient->getStoreHash() . '/' . $this->getApiVersion() . '/' . $end_point . ($id ? ('/' . $id) : '');
    }

    public function query($endPoint): self
    {
        $this->endPoint = $endPoint;
        return $this;
    }

    public function all($query_data = null)
    {
        $response = $this->bigCommerceClient->get($this->generateUrl($this->endPoint), $query_data);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function get($id, $query_data = null)
    {
        $response = $this->bigCommerceClient->get($this->generateUrl($this->endPoint, $id), $query_data);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function create($form_data = [])
    {
        $response = $this->bigCommerceClient->post($this->generateUrl($this->endPoint), $form_data);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function update($id, $form_data = [])
    {
        $response = $this->bigCommerceClient->put($this->generateUrl($this->endPoint, $id), $form_data);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function updateMultiple($form_data = [])
    {
        $response = $this->bigCommerceClient->put($this->generateUrl($this->endPoint), $form_data);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function delete($id)
    {
        $response = $this->bigCommerceClient->delete($this->generateUrl($this->endPoint, $id));
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function deleteMultiple($ids = [])
    {
        $ids_string = '?id:in[]=';
        $first = true;
        foreach ($ids as $id) {
            $ids_string .= ($first ? '' : ',') . $id;
            if ($first)
                $first = false;
        }
        $response = $this->bigCommerceClient->delete($this->generateUrl($this->endPoint) . $ids_string);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }
}