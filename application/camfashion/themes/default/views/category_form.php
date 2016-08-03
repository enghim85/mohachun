<?php include '_header.php';?>
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
                    <?php echo form_open_multipart($this->config->item('admin_folder') . '/categories/form/' . $id); ?>

                    <div class="tabbable">

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#description_tab" data-toggle="tab"><?php echo lang('description'); ?></a></li>
                            <li><a href="#attributes_tab" data-toggle="tab"><?php echo lang('attributes'); ?></a></li>
                            <li><a href="#seo_tab" data-toggle="tab"><?php echo lang('seo'); ?></a></li>
                        </ul>

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

                                    <label for="sequence"><?php echo lang('sequence'); ?> </label>
                                    <?php
                                    $data = array('name' => 'sequence', 'value' => set_value('sequence', $sequence));
                                    echo form_input($data);
                                    ?>

                                    <label for="slug"><?php echo lang('parent'); ?> </label>
                                    <?php
                                    $data = array(0 => 'Top Level Category');
                                    foreach ($categories as $parent) {
                                        if ($parent->id_cate != $id) {
                                            $data[$parent->id_cate] = $parent->name;
                                        }
                                    }
                                    echo form_dropdown('parent_id', $data, $parent_id);
                                    ?>

                                    <label for="excerpt"><?php echo lang('excerpt'); ?> </label>
                                    <?php
                                    $data = array('id' => 'excerpt', 'name' => 'excerpt', 'value' => set_value('excerpt', $excerpt), 'class' => 'span12', 'rows' => 3);
                                    echo form_textarea($data);
                                    ?>

                                    <label for="image"><?php echo lang('image'); ?> </label>
                                    <div class="input-append">
                                        <?php echo form_upload(array('name' => 'image')); ?><span class="add-on"><?php echo lang('max_file_size'); ?> <?php echo $this->config->item('size_limit') / 1024; ?>kb</span>
                                    </div>

                                    <?php if ($id && $image != ''): ?>

                                        <div style="text-align:center; padding:5px; border:1px solid #ddd;"><img src="<?php echo base_url('uploads/images/small/' . $image); ?>" alt="current"/><br/><?php echo lang('current_file'); ?></div>

                                    <?php endif; ?>

                                </fieldset>

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

                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><?php echo lang('form_save'); ?></button> <button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo site_url($this->config->item('admin_folder')."/categories")?>'"><?php echo lang('form_cancel'); ?></button>
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
            <?php include '_footer.php';?>