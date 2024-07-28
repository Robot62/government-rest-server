<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Pemimpin extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pemimpin_model', 'pemimpin');

        $this->methods['index_get']['limit'] = 10;
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $pemimpin = $this->pemimpin->getPemimpin();
        } else {
            $pemimpin = $this->pemimpin->getPemimpin($id);
        }
        if ($pemimpin) {
            $this->response([
                'status' => true,
                'data' => $pemimpin
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->pemimpin->deletePemimpin($id) > 0) {
                //ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'data pemimpin has been deleted!'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                //id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    public function index_post()
    {
        $data = [
            'id' => $this->post('id'),
            'no_pemimpin' => $this->post('no_pemimpin'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email')
        ];
        if ($this->pemimpin->createPemimpin($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pemimpin has been created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function index_put()
    {
        // kenapa dibedakan agar id masuk ke where
        $id = $this->put('id');
        $data = [
            'id' => $this->put('id'),
            'no_pemimpin' => $this->put('no_pemimpin'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email')
        ];
        if ($this->pemimpin->updatePemimpin($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data pemimpin has been updated.'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'failed to update data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
