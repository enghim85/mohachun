<?php

Class M_category extends CI_Model {

    function get_categories($parent = false) {
        if ($parent !== false) {
            $this->db->where('parent_id', $parent);
        }
        $this->db->select('id_cate');
        $this->db->order_by('mc_categories.sequence', 'ASC');

        //this will alphabetize them if there is no sequence
        $this->db->order_by('name', 'ASC');
        $result = $this->db->get('mc_categories');

        $categories = array();
        foreach ($result->result() as $cat) {
            $categories[] = $this->get_category($cat->id_cate);
        }

        return $categories;
    }

    //this is for building a menu
    function get_categories_tierd($parent = 0) {
        $categories = array();
        $result = $this->get_categories($parent);
        foreach ($result as $category) {
            $categories[$category->id_cate]['category'] = $category;
            $categories[$category->id_cate]['children'] = $this->get_categories_tierd($category->id_cate);
        }
        return $categories;
    }

    function category_autocomplete($name, $limit) {
        return $this->db->like('name', $name)->get('mc_categories', $limit)->result();
    }

    function get_category($id) {
        return $this->db->get_where('mc_categories', array('id_cate' => $id))->row();
    }

    function get_category_products_admin($id) {
        $this->db->order_by('sequence', 'ASC');
        $result = $this->db->get_where('category_products', array('category_id' => $id));
        $result = $result->result();

        $contents = array();
        foreach ($result as $product) {
            $result2 = $this->db->get_where('products', array('id' => $product->product_id));
            $result2 = $result2->row();

            $contents[] = $result2;
        }

        return $contents;
    }

    function get_category_products($id, $limit, $offset) {
        $this->db->order_by('sequence', 'ASC');
        $result = $this->db->get_where('category_products', array('category_id' => $id), $limit, $offset);
        $result = $result->result();

        $contents = array();
        $count = 1;
        foreach ($result as $product) {
            $result2 = $this->db->get_where('products', array('id' => $product->product_id));
            $result2 = $result2->row();

            $contents[$count] = $result2;
            $count++;
        }

        return $contents;
    }

    function organize_contents($id, $products) {
        //first clear out the contents of the category
        $this->db->where('category_id', $id);
        $this->db->delete('category_products');

        //now loop through the products we have and add them in
        $sequence = 0;
        foreach ($products as $product) {
            $this->db->insert('category_products', array('category_id' => $id, 'product_id' => $product, 'sequence' => $sequence));
            $sequence++;
        }
    }

    function save($category) {
        if ($category['id_cate']) {
            $this->db->where('id_cate', $category['id_cate']);
            $this->db->update('mc_categories', $category);

            return $category['id_cate'];
        } else {
            $this->db->insert('mc_categories', $category);
            return $this->db->insert_id();
        }
    }

    function delete($id) {
        $this->db->where('id_cate', $id);
        $this->db->delete('mc_categories');

        //delete references to this category in the product to category table
        //$this->db->where('category_id', $id);
        //$this->db->delete('category_products');
    }

}