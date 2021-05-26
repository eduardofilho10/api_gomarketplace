
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Product_model');
    $this->load->helper('url_helper');
  }
  
  public function products()
  { 
    header("Access-Control-Allow-Origin: *");
    $products = $this->Product_model->get_products();
    $this->output->set_content_type('application/json')->set_output(json_encode($products));
  
  }

  public function getProduct($id)
  { 
    
    header('Access-Control-Allow-Origin: *');
   
    $product = $this->Product_model->get_product($id);

    $productData = array(
      'id' => $product->id,
      'product_name' => $product->product_name,
      'product_price' => $product->product_price,
      'product_description' => $product->product_description,
      'product_image' => $product->product_image
    );

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($productData));
   }

  public function createProduct()
  { 
    header("Content-type:application/json");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');

    $requestData = json_decode(file_get_contents('php://input'), true);

    if( ! empty($requestData)) {

      $productName = $requestData['title'];
      $productPrice = $requestData['price'];
      $productImage = $requestData['image_url'];
      $productavailable = 'true';
      
      $productData = array(
        'title' => $productName,
        'price' => $productPrice,
        'image_url' => $productImage,
        'available' =>$productavailable
      );

      $id = $this->Product_model->insert_product($productData);

      $response = array(
        'status' => 'success',
        'message' => 'Product added successfully'
      );
    }
    else {
      $response = array(
        'status' => 'error'
      );
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  public function updateProduct($id)
  { 
    header("Content-type:application/json");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');

    $requestData = json_decode(file_get_contents('php://input'), true);

    if(!empty($requestData)) {

      $productName = $requestData['title'];
      $productPrice = $requestData['price'];
      $productImage = $requestData['image_url'];
      
      
      $productData = array(
        'title' => $productName,
        'price' => $productPrice,
        'image_url' => $productImage
        
      );

      $id = $this->Product_model->update_product($id, $productData);

      $response = array(
        'status' => 'success',
        'message' => 'Product updated successfully.'
      );
    }
    else {
      $response = array(
        'status' => 'error'
      );
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }
  
   public function updateProductDisponsivelInds($id)
  { 
    header("Content-type:application/json");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');

    $requestData = json_decode(file_get_contents('php://input'), true);

    if(!empty($requestData)) {

       $productavailable = $requestData['switch'];
      
      
      $productData = array(
        'available' =>$productavailable
        
      );

      $id = $this->Product_model->update_product($id, $productData);

      $response = array(
        'status' => 'success',
        'message' => 'Product updated successfully.'
      );
    }
    else {
      $response = array(
        'status' => 'error'
      );
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  public function deleteProduct($id)
  {
    header("Content-type:application/json");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
	
	
    
    $product = $this->Product_model->delete_product($id);
	
    $response = array(
      'message' => 'Product deleted successfully.'
    );

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }
}
?>
