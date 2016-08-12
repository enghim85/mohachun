<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_game
 *
 * @author him
 */
class m_shop extends CI_Model {
    //put your code here
    function get($shopId){
        $arr_shop = config_item('shop');
        foreach($arr_shop as $cat => $shops){
            foreach($shops as $id => $shop_name){
                if($id = $shopId){
                    return $shop_name;
                }
            }
        }
    }
    function random(){        
        $this->db->order_by('id_shop', 'RANDOM');
        $this->db->limit(1);
        $query = $this->db->get('mc_shops');
        $result = $query->result();       
        return $result[0]->id_fb;
    }
    function shop_autocomplete($name, $limit) {
        return $this->db->like('shop_name', $name)->get('mc_shops', $limit)->result();
    }
    function shops($data = array(), $return_count = false) {
        if (empty($data)) {
            //if nothing is provided return the whole shabang
            $this->get_all_products();
        } else {
            //grab the limit
            if (!empty($data['rows'])) {
                $this->db->limit($data['rows']);
            }

            //grab the offset
            if (!empty($data['page'])) {
                $this->db->offset($data['page']);
            }

            //do we order by something other than category_id?
            if (!empty($data['order_by'])) {
                //if we have an order_by then we must have a direction otherwise KABOOM
                $this->db->order_by($data['order_by'], $data['sort_order']);
            }

            //do we have a search submitted?
            if (!empty($data['term'])) {
                $search = json_decode($data['term']);
                //if we are searching dig through some basic fields
                if (!empty($search->term)) {
                    $this->db->like('name', $search->term);
                    $this->db->or_like('description', $search->term);
                    $this->db->or_like('excerpt', $search->term);
                    $this->db->or_like('sku', $search->term);
                }

                if (!empty($search->category_id)) {
                    //lets do some joins to get the proper category shops
                    $this->db->join('mc_category_shops as cate_shop', 'cate_shop.shop_id=shop.id_shop', 'right');
                    $this->db->where('cate_shop.category_id', $search->category_id);
                    $this->db->order_by('sequence', 'ASC');
                }
            }

            if ($return_count) {
                return $this->db->count_all_results('mc_shops as shop');
            } else {
                return $this->db->get('mc_shops')->result();
            }
        }
    }
    function get_shops($category_id = false, $limit = false, $offset = false, $by = false, $sort = false) {
        //if we are provided a category_id, then get shops according to category
        if ($category_id) {
            $this->db->select('mc_category_shops.*,mc_shops.*', false)->from('mc_category_shops')->join('mc_shops', 'mc_category_shops.shop_id=mc_shops.id_shop')->where(array('cate_id' => $category_id, 'enabled' => 1));
            $this->db->order_by($by, $sort);

            $result = $this->db->limit($limit)->offset($offset)->get()->result();
            /*
            $contents = array();
            $count = 0;
            foreach ($result as $shop) {

                $contents[$count] = $this->get_shop($shop->shop_id);
                $count++;
            }
            */
            return $result;
        } 
        /*
        else {
            //sort by alphabetically by default
            $this->db->order_by('name', 'ASC');
            $result = $this->db->get('mc_shops');
            //apply group discount
            $return = $result->result();            
            return $return;
        }
         * 
         */
    }
    function get_shop($id, $related = true) {
        $result = $this->db->get_where('mc_shops', array('id_shop' => $id))->row();
        if (!$result) {
            return false;
        }

        $related = json_decode($result->related_shops);

        if (!empty($related)) {
            //build the where
            $where = false;
            foreach ($related as $r) {
                if (!$where) {
                    $this->db->where('id_shop', $r);
                } else {
                    $this->db->or_where('id_shop', $r);
                }
                $where = true;
            }

            $result->related_shops = $this->db->get('mc_shops')->result();
        } else {
            $result->related_shops = array();
        }
        $result->categories = $this->get_shop_categories($result->id_shop);      

        return $result;
    }
    
    function get_shop_by_fbId($id, $related = true) {
        $result = $this->db->get_where('mc_shops', array('id_fb' => $id))->row();
        if (!$result) {
            return false;
        }

        $related = json_decode($result->related_shops);

        if (!empty($related)) {
            //build the where
            $where = false;
            foreach ($related as $r) {
                if (!$where) {
                    $this->db->where('id_shop', $r);
                } else {
                    $this->db->or_where('id_shop', $r);
                }
                $where = true;
            }

            $result->related_shops = $this->db->get('mc_shops')->result();
        } else {
            $result->related_shops = array();
        }
        $result->categories = $this->get_shop_categories($result->id_shop);      

        return $result;
    }
    
    function get_shop_categories($id) {
        return $this->db->where('shop_id', $id)->join('mc_categories', 'mc_category_shops.cate_id = mc_categories.id_cate')->get('mc_category_shops')->result();
    }
    
    function save($shop,$categories=false) {
        if ($shop['id_shop']) {
            $this->db->where('id_shop', $shop['id_shop']);
            $this->db->update('mc_shops', $shop);

            $id = $shop['id_shop'];
        } else {
            $this->db->insert('mc_shops', $shop);
            $id	= $this->db->insert_id();
        }
        
        if ($categories !== false) {
            if ($shop['id_shop']) {
                //get all the categories that the product is in
                $cats = $this->get_shop_categories($id);

                //generate cat_id array
                $ids = array();
                foreach ($cats as $c) {
                    $ids[] = $c->id_cate;
                }

                //eliminate categories that products are no longer in
                foreach ($ids as $c) {
                    if (!in_array($c, $categories)) {
                        $this->db->delete('mc_category_shops', array('shop_id' => $id, 'cate_id' => $c));
                    }
                }

                //add products to new categories
                foreach ($categories as $c) {
                    if (!in_array($c, $ids)) {
                        $this->db->insert('mc_category_shops', array('shop_id' => $id, 'cate_id' => $c));
                    }
                }
            } else {
                //new product add them all
                foreach ($categories as $c) {
                    $this->db->insert('mc_category_shops', array('shop_id' => $id, 'cate_id' => $c));
                }
            }
        }
        return $id;
    }
    function delete_shop($id) {
        // delete product 
        $this->db->where('id_shop', $id);
        $this->db->delete('mc_shops');

        //delete references in the product to category table
        $this->db->where('shop_id', $id);
        $this->db->delete('mc_category_shops');
    }
}

?>
