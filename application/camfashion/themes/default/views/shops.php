<?php include '_header.php';
//set "code" for searches
if (!$code) {
    $code = '';
} else {
    $code = '/' . $code;
}

function sort_url($lang, $by, $sort, $sorder, $code, $admin_folder) {
    if ($sort == $by) {
        if ($sorder == 'asc') {
            $sort = 'desc';
            $icon = ' <i class="icon-chevron-up"></i>';
        } else {
            $sort = 'asc';
            $icon = ' <i class="icon-chevron-down"></i>';
        }
    } else {
        $sort = 'asc';
        $icon = '';
    }


    $return = site_url($admin_folder . '/shops/index/' . $by . '/' . $sort . '/' . $code);

    echo '<a href="' . $return . '">' . lang($lang) . $icon . '</a>';
}

if (!empty($term)):
    $term = json_decode($term);
    if (!empty($term->term) || !empty($term->category_id)):
        ?>
        <div class="alert alert-info">
        <?php echo sprintf(lang('search_returned'), intval($total)); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('confirm_delete_shop'); ?>');
    }
</script>
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
                    <?php if(!empty($page_title)):?>
                    <div class="page-header">
                            <h1><?php echo  $page_title; ?></h1>
                    </div>
                    <?php endif;?>                                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?php echo sort_url('id_fb', 'id_fb', $order_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
                                <th><?php echo sort_url('shop_name', 'shop_name', $order_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>                                
                                <th><?php echo sort_url('address', 'address', $order_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
                                <th><?php echo sort_url('phone_shop', 'phone', $order_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
                                <th><?php echo sort_url('url_fb', 'url_fb', $order_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
                                <th>
                                    <span class="btn-group pull-right">                                        
                                        <a class="btn" style="font-weight:normal;"href="<?php echo site_url($this->config->item('admin_folder') . '/shops/form'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_shop'); ?></a>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo (count($shops) < 1) ? '<tr><td style="text-align:center;" colspan="7">' . lang('no_shops') . '</td></tr>' : '' ?>
                            <?php foreach ($shops as $shop): ?>
                                <tr>                                    
                                    <td><?php echo $shop->id_fb; ?></td>
                                    <td><?php echo $shop->shop_name; ?></td>
                                    <td><?php echo $shop->address ?></td>
                                    <td><?php echo $shop->phone ?></td>                                    
                                    <td><?php echo $shop->url_fb; ?></td>
                                    <td>
                                        <span class="btn-group pull-right">
                                            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/shops/form/' . $shop->id_shop); ?>"><i class="icon-pencil"></i>  <?php echo lang('edit'); ?></a>                                            
                                            <a class="btn btn-danger" href="<?php echo site_url($this->config->item('admin_folder') . '/shops/delete/' . $shop->id_shop); ?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete'); ?></a>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php include '_footer.php';?>