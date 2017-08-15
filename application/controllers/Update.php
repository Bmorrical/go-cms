<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Update extends GO_Controller { 

  public function updator(){

    try {
    $client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://raw.githubusercontent.com/hussaindev53/Task-Manager/master/',
    ]);
     $response = $client->request('GET','abcd.php');
} catch (RequestException $e) {
  
    echo Psr7\str($e->getRequest());
    if ($e->hasResponse()) {
      
        echo Psr7\str($e->getResponse());
    }
}
  
    /*$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://raw.githubusercontent.com/hussaindev53/Task-Manager/master/',
    ]);

     $response = $client->request('GET','abcd.php');
     echo $response->getStatusCode();die;

    $fileToRead = fopen(FCPATH."version.txt","r") or die("Unable to open file");

    while(!feof($fileToRead)){

      $fileName = trim(fgets($fileToRead));

      $response = $client->request('GET',$fileName);

      $fileToWrite = fopen(FCPATH."updatedFiles/".$fileName, 'w') or die('Unable to Open a file');

      fwrite($fileToWrite, $response->getBody());

      fclose($fileToWrite);
    }

    fclose($fileToRead);*/
  }

}