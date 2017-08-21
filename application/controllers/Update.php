<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Update extends GO_Controller { 

  public function updator(){

    /*try {
      $client = new Client([
      // Base URI is used with relative requests
      'base_uri' => 'https://raw.githubusercontent.com/hemantyuva/go-cms-versions/version1.1/',
      ]);
       $response = $client->request('GET','version.txt');
    } catch (RequestException $e) {

      echo Psr7\str($e->getRequest());
      if ($e->hasResponse()) {
        echo Psr7\str($e->getResponse());
      }
    }*/
  
    $client = new Client([
      // Base URI is used with relative requests
      'base_uri' => 'https://raw.githubusercontent.com/hemantyuva/go-cms-versions/version'.$this->input->post('updateVersion').'/',
      ]);
    $response = $client->request('GET','version.txt');

    //echo $response->getBody();die;

    $fileNames = explode(',',trim($response->getBody()));

    foreach($fileNames as $fileName){

      $response = $client->request('GET',$fileName);

      $fileToWrite = fopen(FCPATH.$fileName, 'w') or die('Unable to Open a file');

      fwrite($fileToWrite, $response->getBody());

      fclose($fileToWrite);
    }

    $this->admin->go_set_version($this->input->post('updateVersion'));

    echo json_encode(["status" => "success", "message" => "Updation successfully completed"]);

  }

}