<?php include '_header.php';?>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><span>Lumino</span>Admin</a>
                    <ul class="user-menu">
                        <li class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
                                <li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
                                <li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div><!-- /.container-fluid -->
        </nav>

        <?php include '_sidebar.php';?>

        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                    <li class="active">Icons</li>
                </ol>
            </div><!--/.row-->

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
            </div><!--/.row-->


            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Form Elements</div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <form role="form">

                                    <div class="form-group">
                                        <label>Text Input</label>
                                        <input class="form-control" placeholder="Placeholder">
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control">
                                    </div>

                                    <div class="form-group checkbox">
                                        <label>
                                            <input type="checkbox">Remember me</label>
                                    </div>

                                    <div class="form-group">
                                        <label>File input</label>
                                        <input type="file">
                                        <p class="help-block">Example block-level help text here.</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Text area</label>
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>

                                    <label>Validation</label>
                                    <div class="form-group has-success">
                                        <input class="form-control" placeholder="Success">
                                    </div>
                                    <div class="form-group has-warning">
                                        <input class="form-control" placeholder="Warning">
                                    </div>
                                    <div class="form-group has-error">
                                        <input class="form-control" placeholder="Error">
                                    </div>

                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Checkboxes</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">Checkbox 1
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">Checkbox 2
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">Checkbox 3
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">Checkbox 4
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Radio Buttons</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>Radio Button 1
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Radio Button 2
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">Radio Button 3
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">Radio Button 4
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Selects</label>
                                    <select class="form-control">
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                        <option>Option 4</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Multiple Selects</label>
                                    <select multiple class="form-control">
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                        <option>Option 4</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit Button</button>
                                <button type="reset" class="btn btn-default">Reset Button</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.col-->
            </div><!-- /.row -->

        </div><!--/.main-->

        <?php include '_js_footer.php';?>
        <script>
            !function($) {
                $(document).on("click", "ul.nav li.parent > a > span.icon", function() {
                    $(this).find('em:first').toggleClass("glyphicon-minus");
                });
                $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
            }(window.jQuery);

            $(window).on('resize', function() {
                if ($(window).width() > 768)
                    $('#sidebar-collapse').collapse('show')
            })
            $(window).on('resize', function() {
                if ($(window).width() <= 767)
                    $('#sidebar-collapse').collapse('hide')
            })
        </script>	
    <?php include '_footer.php';?>
