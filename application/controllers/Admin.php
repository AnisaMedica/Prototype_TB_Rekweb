<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller {
        
    
    public function __construct() {
        parent::__construct();
        is_logged();
        $this->load->model('Admin_model');
        $this->load->library('upload');
        $this->load->library('form_validation');


    }

    public function index() {
        $data['barang'] = $this->Admin_model->getAllBarang();
        $data['title'] = "Dashboard";
        $data['user'] = $this->db->get_where('user', ['email'=>
        $this->session->userdata('email')])->row_array();
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/ecommerce_footer');
    }

      public function tambah()
        {
        $data['title'] = "Tambah barang baru";

        $this->load->view('templates/admin_header', $data);
        return $this->load->view('admin/tambah');
        $this->load->view('templates/ecommerce_footer');
    }

        public function error()
        {
        $data['title'] = "Error Page";

        $this->load->view('templates/admin_header', $data);
        return $this->load->view('admin/error');
        $this->load->view('templates/ecommerce_footer');
    }

    public function insertdata()
    {

      $nama_barang   = $this->input->post('nama_barang');
      $jenis_barang   = $this->input->post('jenis_barang');
      $harga_barang   = $this->input->post('harga_barang');
      $stock_barang   = $this->input->post('stock_barang');
      $deskripsi_barang   = $this->input->post('deskripsi_barang');

      // get foto
      $config['upload_path'] = './assets/img/';
      $config['allowed_types'] = 'jpg|png|jpeg|gif';
      $config['max_size'] = '2048';  //2MB max
      $config['max_width'] = '4480'; // pixel
      $config['max_height'] = '4480'; // pixel
      $config['file_name'] = $_FILES['fotopost']['name'];

      $this->upload->initialize($config);

        if (!empty($_FILES['fotopost']['name'])) {
            if ( $this->upload->do_upload('fotopost') ) {
                $foto = $this->upload->data();
                $data = array(
                              'nama_barang'  => $nama_barang,
                              'jenis_barang'  => $jenis_barang,
                              'harga_barang'  => $harga_barang,
                              'stock_barang'  => $stock_barang,
                              'deskripsi_barang'  => $deskripsi_barang,
                              'image'        => $foto['file_name'],
                            );
                            $this->Admin_model->insert($data);
              redirect('admin');
            }else {
              die("gagal upload");
            }
        }else {
          redirect('admin/error');
        }
      }

      public function edit($id)
  {
      $data['title'] = "Ubah barang";
      $data['data'] = $this->Admin_model->getBarangById($id);
      $this->load->view('templates/admin_header', $data);
      return $this->load->view('admin/edit',$data);
      $this->load->view('templates/ecommerce_footer');
  }

      public function updatedata() {
      $nama_barang   = $this->input->post('nama_barang');
      $jenis_barang   = $this->input->post('jenis_barang');
      $harga_barang   = $this->input->post('harga_barang');
      $stock_barang   = $this->input->post('stock_barang');
      $deskripsi_barang   = $this->input->post('deskripsi_barang');

      $path = './assets/img/';

      $config['upload_path'] = './assets/img';
      $config['allowed_types'] = 'jpg|png|jpeg|gif';
      $config['max_size'] = '2048';  //2MB max
      $config['max_width'] = '4480'; // pixel
      $config['max_height'] = '4480'; // pixel
      $config['file_name'] = $_FILES['fotopost']['name'];

      $this->upload->initialize($config);

      if (!empty($_FILES['fotopost']['name'])) {
          if ( $this->upload->do_upload('fotopost') ) {
              $foto = $this->upload->data();
              $data = array(
                              'nama_barang'  => $nama_barang,
                              'jenis_barang'  => $jenis_barang,
                              'harga_barang'  => $harga_barang,
                              'stock_barang'  => $stock_barang,
                              'deskripsi_barang'  => $deskripsi_barang,
                              'image'        => $foto['file_name'],
                          );
              // hapus foto pada direktori
              @unlink($path.$this->input->post('filelama'));
              
              $this->db->set('name', $name);
              $this->db->where('email', $email);
              $this->db->update('barang');
              redirect('admin');
          }else {
              die("gagal update");
          }
      }else {
        redirect('admin/error');
      }
  }


  //kok pusing
}