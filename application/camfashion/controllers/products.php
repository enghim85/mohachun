<?php

class Products extends Front_Controller {

    function __construct() {
        parent::__construct();
        //load model
        $this->load->model("m_category");
        $this->load->model("m_routes");
        $this->load->model("m_shop");
        
        $this->load->helper('language');
        $this->load->helper('My_string');
        //load the base language file
        $this->lang->load('admin_common');
        $this->lang->load('common');
        $this->lang->load('shop');        
        $this->lang->load('category');        
        //Library
        $this->load->library('facebook', array(
            'appId' => config_item('appId'),
            'secret' => config_item('secret'),
        ));
    }

    function index($order_by = "id_shop", $sort_order = "DESC", $code = 0, $page = 0, $rows = 15) {

        $data['page_title'] = lang('shops');

        $data['code'] = $code;
        $term = false;
        $category_id = false;

        //get the category list for the drop menu
        $data['categories'] = $this->m_category->get_categories_tierd();

        $post = $this->input->post(null, false);
        $this->load->model('m_search');
        if ($post) {
            $term = json_encode($post);
            $code = $this->m_search->record_term($term);
            $data['code'] = $code;
        } elseif ($code) {
            $term = $this->m_search->get_term($code);
        }

        //store the search term
        $data['term'] = $term;
        $data['order_by'] = $order_by;
        $data['sort_order'] = $sort_order;

        $data['shops'] = $this->m_shop->shops(array('term' => $term, 'order_by' => $order_by, 'sort_order' => $sort_order, 'rows' => $rows, 'page' => $page));

        //total number of products
        $data['total'] = $this->m_shop->shops(array('term' => $term, 'order_by' => $order_by, 'sort_order' => $sort_order), true);


        $this->load->library('pagination');

        $config['base_url'] = site_url('admin/products/index/' . $order_by . '/' . $sort_order . '/' . $code . '/');
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $rows;
        $config['uri_segment'] = 7;
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_open'] = '<div class="pagination"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $this->load->view('admin/products', $data);
    }
    //basic category search
    function shop_autocomplete() {
        $name = trim($this->input->post('name'));
        $limit = $this->input->post('limit');

        if (empty($name)) {
            echo json_encode(array());
        } else {
            $results = $this->m_shop->shop_autocomplete($name, $limit);

            $return = array();

            foreach ($results as $r) {
                $return[$r->id_shop] = $r->shop_name;
            }
            echo json_encode($return);
        }
    }
    function form($id = false) {       

        $this->category_id = $id;
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data['categories'] = $this->m_category->get_categories();
        $data['page_title'] = "Shop Form";

        //default values are empty if the customer is new
        $data['id'] = '';
        $data['name'] = '';
        $data['slug'] = '';
        $data['url_fb'] = '';
        $data['address'] = '';
        $data['phone'] = '';
        $data['description'] = '';
        $data['seo_title'] = '';
        $data['meta'] = '';
        $data['related_shops']	= array();
	$data['shop_categories']	= array();

        if ($id) {
            $shop = $this->m_shop->get_shop($id);

            //if the category does not exist, redirect them to the category list with an error
            if (!$shop) {
                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect($this->config->item('admin_folder') . '/shops');
            }

            //helps us with the slug generation
            $this->shop_name = $this->input->post('slug', $shop->slug);

            //set values to db values
            $data['id'] = $shop->id_shop;
            $data['name'] = $shop->shop_name;
            $data['slug'] = $shop->slug;
            $data['url_fb'] = $shop->url_fb;
            $data['address'] = $shop->address;
            $data['phone'] = $shop->phone;
            $data['description'] = $shop->shop_des;                        
            $data['seo_title'] = $shop->seo_title;
            $data['meta'] = $shop->meta;
            $data['shop_categories']	= $shop->categories;
            $data['related_shops'] = $shop->related_shops;
        }

        $this->form_validation->set_rules('name', 'lang:name', 'trim|required|max_length[64]');
        $this->form_validation->set_rules('slug', 'lang:slug', 'trim');
        $this->form_validation->set_rules('description', 'lang:description', 'trim');                       
        $this->form_validation->set_rules('seo_title', 'lang:seo_title', 'trim');
        $this->form_validation->set_rules('meta', 'lang:meta', 'trim');


        // validate the form
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/product_form', $data);
        } else {                      

            $this->load->helper('text');

            //first check the slug field
            $slug = $this->input->post('slug');

            //if it's empty assign the name field
            if (empty($slug) || $slug == '') {
                $slug = $this->input->post('name');
            }

            $slug = url_title(convert_accented_characters($slug), 'dash', TRUE);

            //validate the slug            
            if ($id) {
                $slug = $this->m_routes->validate_slug($slug, $shop->route_id);
                $route_id = $shop->route_id;
            } else {
                $slug = $this->m_routes->validate_slug($slug);

                $route['slug'] = $slug;
                $route_id = $this->m_routes->save($route);
            }

            $save['id_shop'] = $id;
            $save['shop_name'] = $this->input->post('name');
            $save['shop_des'] = $this->input->post('description');            
            $save['url_fb'] = $this->input->post('url_fb');
            $save['id_fb'] = getFbId($save['url_fb']);
            $save['address'] = $this->input->post('address');
            $save['phone'] = $this->input->post('phone');
            $save['seo_title'] = $this->input->post('seo_title');
            $save['meta'] = $this->input->post('meta');

            $save['route_id'] = intval($route_id);
            $save['slug'] = $slug;
            
            if($this->input->post('related_shops'))
            {
                    $save['related_shops'] = json_encode($this->input->post('related_shops'));
            }
            else
            {
                    $save['related_shops'] = '';
            }

            //save categories
            $categories			= $this->input->post('categories');            
            if(!$categories)
            {
                    $categories	= array();
            }

            $id_shop = $this->m_shop->save($save,$categories);

            //save the route
            $route['id_route'] = $route_id;
            $route['slug'] = $slug;
            $route['route'] = 'shops/index/' . $id_shop . '';

            $this->m_routes->save($route);

            $this->session->set_flashdata('message', lang('message_category_saved'));

            //go back to the category list
            redirect('admin/shops');
        }
    }
    function delete($id = false) {
        if ($id) {
            $shop = $this->m_shop->get_shop($id);
            //if the product does not exist, redirect them to the customer list with an error
            if (!$shop) {
                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect($this->config->item('admin_folder') . '/shop');
            } else {

                // remove the slug                
                $this->m_routes->remove('(' . $shop->slug . ')');

                //if the product is legit, delete them
                $this->m_shop->delete_shop($id);

                $this->session->set_flashdata('message', lang('message_deleted_shop'));
                redirect($this->config->item('admin_folder') . '/shops');
            }
        } else {
            //if they do not provide an id send them to the product list page with an error
            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/shops');
        }
    }
}