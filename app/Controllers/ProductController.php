<?php 
namespace App\Controllers;
use App\Models\ProductModel;
use CodeIgniter\Controller;

class ProductController extends Controller
{
    private $product = '' ;
    public function __construct(){
      
        $this->product = new ProductModel();       
    }
    
    // show product list
    public function index()
    {
        $session = session(); 
        $data['products'] = $this->product->orderBy('product_id', 'DESC')->findAll();       
        return view('products',$data);
    }
    
    // insert data
    public function store() {
       
        $data = [
            'product' => $this->request->getVar('product'),
            'category'  => $this->request->getVar('category'),
            'price'  => $this->request->getVar('price'),
            'sku'  => $this->request->getVar('sku'),          
            'model'  => $this->request->getVar('model'),
        ];
        
        $this->product->insert($data);    
        $session = session(); 
        $session->setFlashdata('msg', 'Product Successfully Added');   
        return $this->response->redirect(site_url('/list'));
    }

    // show product by id
    public function edit($product_id){
          
        $data['product'] = $this->product->where('product_id', $product_id)->first();
        echo json_encode($data['product']); 
    }

    // update product data
    public function update(){
        
         $id = $this->request->getVar('id');
        $data = [
            'product' => $this->request->getVar('product'),
            'category'  => $this->request->getVar('category'),
            'price'  => $this->request->getVar('price'),
            'sku'  => $this->request->getVar('sku'),          
            'model'  => $this->request->getVar('model'),
        ];
        $this->product->update($id, $data);        
        return $this->response->redirect(site_url('/list'));
    }

     // delete product
     public function delete(){
      
        $id = $this->request->getVar('delete_id');
       
        $data['product'] = $this->product->where('product_id', $id)->delete($id);
        
    //    print_r($data['product']);
    //    die;
        return $this->response->redirect(site_url('/list'));
        
    }   

}