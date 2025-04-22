<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;

class DummyService
{
    private string $baseUrl = 'https://dummyjson.com/';
    private string $endpoint;
    private string $filter = '/search?q=';
    public function __construct(string $endpoint, string $filter){
        $this->endpoint = $endpoint;
        $this->filter .= $filter;
    }
    public function getProductData(){
        $fullUrl = $this->baseUrl.$this->endpoint.$this->filter;
        $response = HTTP::withoutVerifying()->get($fullUrl)->json();
        $dataForSave = [];
        foreach($response['products'] as $item){
            $dataForSave[] = [
                'product_id' => $item['product_id'],
                'title' => $item['title'],
                'price' => $item['price'],
            ];
        }
        Product::upsert($dataForSave, 'product_id');
    }
}
