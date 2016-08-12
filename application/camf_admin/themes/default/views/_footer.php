<hr>
            <footer>
                <p>&copy; Vincent Gabriel 2013</p>
            </footer>
        </div>
        <!--/.fluid-container-->        
        <script src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js")?>"></script>
        <script src="<?php echo base_url("assets/easypiechart/jquery.easy-pie-chart.js")?>"></script>
        <script src="<?php echo theme_js("scripts.js")?>"></script>
        <script>
            $(function() {
                // Easy pie charts
                $('.chart').easyPieChart({animate: 1000});
            });
        </script>
    </body>

</html>