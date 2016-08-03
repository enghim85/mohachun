<?php include '_header.php';?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_category');?>');
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
                    <div style="text-align:right">
                        <a class="btn" href="<?php echo site_url('admin/categories/form'); ?>"><i class="icon-plus-sign"></i> <?php echo "Add new"; ?></a>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?php echo "Category ID"; ?></th>
                                <th><?php echo "Name" ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo (count($categories) < 1) ? '<tr><td style="text-align:center;" colspan="3">' . lang('no_categories') . '</td></tr>' : '' ?>
                            <?php
                            define('ADMIN_FOLDER', $this->config->item('admin_folder'));

                            function list_categories($cats, $sub = '') {

                                foreach ($cats as $cat):
                                    ?>
                                    <tr>
                                        <td><?php echo $cat['category']->id_cate; ?></td>
                                        <td><?php echo $sub . $cat['category']->name; ?></td>
                                        <td>
                                            <div class="btn-group" style="float:right">

                                                <a class="btn" href="<?php echo site_url('/admin/categories/form/' . $cat['category']->id_cate); ?>"><i class="icon-pencil"></i> <?php echo "Edit"; ?></a>

                                                <a class="btn" href="<?php echo site_url('/admin/categories/organize/' . $cat['category']->id_cate); ?>"><i class="icon-move"></i> <?php echo "Organize"; ?></a>

                                                <a class="btn btn-danger" href="<?php echo site_url('/admin/categories/delete/' . $cat['category']->id_cate); ?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo "Delete"; ?></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    if (sizeof($cat['children']) > 0) {
                                        $sub2 = str_replace('&rarr;&nbsp;', '&nbsp;', $sub);
                                        $sub2 .= '&nbsp;&nbsp;&nbsp;&rarr;&nbsp;';
                                        list_categories($cat['children'], $sub2);
                                    }
                                endforeach;
                            }

                            list_categories($categories);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php include '_footer.php';?>