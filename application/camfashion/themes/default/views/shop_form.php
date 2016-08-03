<?php include '_header.php'; ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3" id="sidebar">
            <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                <li class="active">
                    <a href="index.html"><i class="icon-chevron-right"></i> Dashboard</a>
                </li>
                <li>
                    <a href="calendar.html"><i class="icon-chevron-right"></i> Calendar</a>
                </li>
                <li>
                    <a href="stats.html"><i class="icon-chevron-right"></i> Statistics (Charts)</a>
                </li>
                <li>
                    <a href="form.html"><i class="icon-chevron-right"></i> Forms</a>
                </li>
                <li>
                    <a href="tables.html"><i class="icon-chevron-right"></i> Tables</a>
                </li>
                <li>
                    <a href="buttons.html"><i class="icon-chevron-right"></i> Buttons & Icons</a>
                </li>
                <li>
                    <a href="editors.html"><i class="icon-chevron-right"></i> WYSIWYG Editors</a>
                </li>
                <li>
                    <a href="interface.html"><i class="icon-chevron-right"></i> UI & Interface</a>
                </li>
                <li>
                    <a href="#"><span class="badge badge-success pull-right">731</span> Orders</a>
                </li>
                <li>
                    <a href="#"><span class="badge badge-success pull-right">812</span> Invoices</a>
                </li>
                <li>
                    <a href="#"><span class="badge badge-info pull-right">27</span> Clients</a>
                </li>
                <li>
                    <a href="#"><span class="badge badge-info pull-right">1,234</span> Users</a>
                </li>
                <li>
                    <a href="#"><span class="badge badge-info pull-right">2,221</span> Messages</a>
                </li>
                <li>
                    <a href="#"><span class="badge badge-info pull-right">11</span> Reports</a>
                </li>
                <li>
                    <a href="#"><span class="badge badge-important pull-right">83</span> Errors</a>
                </li>
                <li>
                    <a href="#"><span class="badge badge-warning pull-right">4,231</span> Logs</a>
                </li>
            </ul>
        </div>

        <!--/span-->
        <div class="span9" id="content">
            <?php if (!empty($page_title)): ?>
                <div class="page-header">
                    <h1><?php echo $page_title; ?></h1>
                </div>
            <?php endif; ?>
            <?php echo form_open_multipart($this->config->item('admin_folder') . '/shops/form/' . $id); ?>

            <div class="tabbable">

                <ul class="nav nav-tabs">
                    <li class="active"><a href="#description_tab" data-toggle="tab"><?php echo lang('description'); ?></a></li>                            
                    <li><a href="#attributes_tab" data-toggle="tab"><?php echo lang('attributes'); ?></a></li>
                    <li><a href="#categories_tab" data-toggle="tab"><?php echo lang('categories'); ?></a></li>
                    <li><a href="#related_shop_tab" data-toggle="tab"><?php echo lang('related_shop'); ?></a></li>
                    <li><a href="#seo_tab" data-toggle="tab"><?php echo lang('seo'); ?></a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="description_tab">

                    <fieldset>
                        <label for="name"><?php echo lang('name'); ?></label>
                        <?php
                        $data = array('id' => 'name', 'name' => 'name', 'value' => set_value('name', $name), 'class' => 'span12');
                        echo form_input($data);
                        ?>

                        <label for="description"><?php echo lang('description'); ?></label>
                        <?php
                        $data = array('id' => 'description', 'name' => 'description', 'class' => 'span12 goedit', 'value' => set_value('description', $description));
                        echo form_textarea($data);
                        ?>
                    </fieldset>
                </div>                            
                <div class="tab-pane" id="attributes_tab">

                    <fieldset>
                        <label for="slug"><?php echo lang('slug'); ?> </label>
                        <?php
                        $data = array('name' => 'slug', 'value' => set_value('slug', $slug));
                        echo form_input($data);
                        ?>                                    
                        <label for="url_fb"><?php echo lang('url_fb'); ?> </label>
                        <?php
                        $data = array('name' => 'url_fb', 'value' => set_value('url_fb', $url_fb));
                        echo form_input($data);
                        ?>
                        <label for="address"><?php echo lang('address_shop'); ?> </label>
                        <?php
                        $data = array('name' => 'address', 'value' => set_value('address', $address));
                        echo form_input($data);
                        ?>
                        <label for="phone"><?php echo lang('phone_mumber'); ?> </label>
                        <?php
                        $data = array('name' => 'phone', 'value' => set_value('phone', $phone));
                        echo form_input($data);
                        ?>                        
                    </fieldset>

                </div>
                <div class="tab-pane" id="categories_tab">                    
                    <div class="row">
                        <div class="span3" style="text-align:center">
                            <div class="row">
                                <div class="span12">
                                    <label><strong><?php echo lang('select_categories'); ?></strong></label>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="span12">
                                    <input type="text" id="category_search" />
                                    <script type="text/javascript">
                                        $('#category_search').keyup(function(){
                                                $('#category_list').html('');
                                                run_category_query();                                                
                                        });

                                        function run_category_query()
                                        {
                                                $.post("<?php echo site_url($this->config->item('admin_folder') . '/categories/category_autocomplete/'); ?>", { name: $('#category_search').val(), limit:10},
                                                        function(data) {                                                                
                                                                $('#category_list').html('');

                                                                $.each(data, function(index, value){

                                                                        if($('#category_'+index).length == 0)
                                                                        {
                                                                                $('#category_list').append('<option id="category_item_'+index+'" value="'+index+'">'+value+'</option>');
                                                                        }
                                                                });

                                                }, 'json');
                                        }
                                        function add_category()
                                        {
                                                //if the related product is not already a related product, add it
                                                if($('#categories_'+$('#category_list').val()).length == 0 && $('#category_list').val() != null)
                                                {
                                                        <?php $new_item	 = str_replace(array("\n", "\t", "\r"),'',category("'+$('#category_list').val()+'", "'+$('#category_item_'+$('#category_list').val()).html()+'"));?>
                                                        var category = '<?php echo $new_item;?>';
                                                        $('#categories_container').append(category);
                                                        run_category_query();
                                                }
                                        }
                                        function remove_category(id)
                                        {
                                                if(confirm('<?php echo lang('confirm_remove_category');?>'))
                                                {
                                                        $('#category_'+id).remove();
                                                        run_category_query();
                                                }
                                        }
                                    </script>
                                    <?php
                                    function category($id, $name) {
                                            return '
                                                            <tr id="category_'.$id.'">
                                                                    <td>
                                                                            <input type="hidden" name="categories[]" value="'.$id.'"/>
                                                                            '.$name.'</td>
                                                                    <td>
                                                                            <a class="btn btn-danger pull-right btn-mini" href="#" onclick="remove_category('.$id.'); return false;"><i class="icon-trash icon-white"></i> '.lang('remove').'</a>
                                                                    </td>
                                                            </tr>
                                                    ';
                                    }
                                    ?>
                                </div>
                            </div>                        
                            <div class="row">
                                <div class="span12">
                                    <select size="5" id="category_list"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span12" style="margin-top:8px;">
                                    <a href="#" onclick="add_category(); return false;" class="btn" title="Add Category"><?php echo lang('add_category'); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <table class="table table-striped" style="margin-top:10px;">
                                <tbody id="categories_container">
                                    <?php                                    
                                    foreach ($shop_categories as $cat) {
                                        echo category($cat->id_cate, $cat->name);
                                    }                                     
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>                                                                        
                </div>
                <div class="tab-pane" id="related_shop_tab">                                
                    <div class="row">
                        <div class="span3" style="text-align:center">
                            <div class="row">
                                <div class="span12">
                                    <label><strong><?php echo lang('select_related_shop'); ?></strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span12">
                                    <input type="text" id="shop_search" />
                                    <script type="text/javascript">
                                    $('#shop_search').keyup(function(){
                                            $('#product_list').html('');
                                            run_shop_query();
                                    });

                                    function run_shop_query()
                                    {
                                            $.post("<?php echo site_url($this->config->item('admin_folder') . '/shops/shop_autocomplete/'); ?>", { name: $('#shop_search').val(), limit:10},
                                                    function(data) {

                                                            $('#shop_list').html('');

                                                            $.each(data, function(index, value){

                                                                    if($('#related_shop_'+index).length == 0)
                                                                    {
                                                                            $('#shop_list').append('<option id="shop_item_'+index+'" value="'+index+'">'+value+'</option>');
                                                                    }
                                                            });

                                            }, 'json');
                                    }
                                    function add_related_shop()
                                    {
                                            //if the related product is not already a related product, add it
                                            if($('#related_shop_'+$('#shop_list').val()).length == 0 && $('#shop_list').val() != null)
                                            {
                                                    <?php $new_item	 = str_replace(array("\n", "\t", "\r"),'',related_items("'+$('#shop_list').val()+'", "'+$('#shop_item_'+$('#shop_list').val()).html()+'"));?>
                                                    var related_product = '<?php echo $new_item;?>';
                                                    $('#shop_items_container').append(related_product);
                                                    run_shop_query();
                                            }
                                            else
                                            {
                                                    if($('#shop_list').val() == null)
                                                    {
                                                            alert('<?php echo lang('alert_select_shop');?>');
                                                    }
                                                    else
                                                    {
                                                            alert('<?php echo lang('alert_shop_related');?>');
                                                    }
                                            }
                                    }
                                    function remove_related_shop(id)
                                    {
                                            if(confirm('<?php echo lang('confirm_remove_related');?>'))
                                            {
                                                    $('#related_shop_'+id).remove();
                                                    run_shop_query();
                                            }
                                    }
                                    </script>
                                    <?php
                                    function related_items($id, $name) {
                                            return '
                                                            <tr id="related_shop_'.$id.'">
                                                                    <td>
                                                                            <input type="hidden" name="related_shops[]" value="'.$id.'"/>
                                                                            '.$name.'</td>
                                                                    <td>
                                                                            <a class="btn btn-danger pull-right btn-mini" href="#" onclick="remove_related_shop('.$id.'); return false;"><i class="icon-trash icon-white"></i> '.lang('remove').'</a>
                                                                    </td>
                                                            </tr>
                                                    ';
                                    }
                                    ?>
                                </div>
                            </div>                        
                            <div class="row">
                                <div class="span12">
                                    <select size="5" id="shop_list"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span12" style="margin-top:8px;">
                                    <a href="#" onclick="add_related_shop();return false;" class="btn" title="Add Related Shop"><?php echo lang('add_related_shop'); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <table class="table table-striped" style="margin-top:10px;">
                                <tbody id="shop_items_container">
                                    <?php                                    
                                    foreach ($related_shops as $rel) {
                                        echo related_items($rel->id_shop, $rel->shop_name);
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>                                
                </div>
                <div class="tab-pane" id="seo_tab">
                    <fieldset>
                        <label for="seo_title"><?php echo lang('seo_title'); ?> </label>
                        <?php
                        $data = array('name' => 'seo_title', 'value' => set_value('seo_title', $seo_title), 'class' => 'span12');
                        echo form_input($data);
                        ?>

                        <label><?php echo lang('meta'); ?></label> 
                        <?php
                        $data = array('rows' => 3, 'name' => 'meta', 'value' => set_value('meta', html_entity_decode($meta)), 'class' => 'span12');
                        echo form_textarea($data);
                        ?>
                        <p class="help-block"><?php echo lang('meta_data_description'); ?></p>
                    </fieldset>
                </div>
            </div>                    

            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><?php echo lang('form_save'); ?></button> <button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo site_url($this->config->item('admin_folder')."/shops")?>'"><?php echo lang('form_cancel'); ?></button>
            </div>
            </form>

            <script type="text/javascript">
                $('form').submit(function() {
                    $('.btn').attr('disabled', true).addClass('disabled');
                });
            </script>
        </div>
    </div>
</div>
<?php include '_footer.php'; ?>