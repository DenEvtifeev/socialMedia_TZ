<?php

namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Http;

class DummyService
{
    private string $baseUrl = 'https://dummyjson.com/';
    private string $endpoint;
    private ?string $filter = null;
    public function __construct(string $endpoint, string $filter){
        $this->endpoint = $endpoint;
        $this->filter = $filter;
    }
    public function getProductData(){
        if($this->filter !== null){
            $fullUrl = $this->baseUrl.$this->endpoint.'?q='.$this->filter;
        }else{
            $fullUrl = $this->baseUrl.$this->endpoint;
        }
        $response = HTTP::withoutVerifying()->get($fullUrl)->json();
        $dataForSave = [];
        foreach($response['products'] as $item){
            $dataForSave[] = [
                'product_id' => $item['product_id'],
                'title' => $item['title'],
                'price' => $item['price'],
            ];
        }
        try{
            Product::upsert($dataForSave, 'product_id');
            dump('data inserted ' . count($dataForSave));
        }catch (Exception $e){
            dump($e->getMessage());
        }

    }
}
