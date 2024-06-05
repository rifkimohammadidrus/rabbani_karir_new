    <!-- Jquery Core Js -->

    <script src="../assets/dashboard/plugins/jquery/jquery.min.js"></script>

    



    <!-- Bootstrap Core Js -->

    <script src="../assets/dashboard/plugins/bootstrap/js/bootstrap.js"></script>





    <!-- Slimscroll Plugin Js -->

    <script src="../assets/dashboard/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>





    <!-- Waves Effect Plugin Js -->

    <script src="../assets/dashboard/plugins/node-waves/waves.js"></script>



    <!-- Jquery CountTo Plugin Js -->

    <script src="../assets/dashboard/plugins/jquery-countto/jquery.countTo.js"></script>



    

    <script src="../assets/dashboard/js/pages/widgets/infobox/infobox-2.js"></script>



    <!-- Autosize Plugin Js -->

    <script src="../assets/dashboard/plugins/autosize/autosize.js"></script>



    <!-- Moment Plugin Js -->

    <script src="../assets/dashboard/plugins/momentjs/moment.js"></script>



    <script src="../assets/dashboard/js/pages/ui/tooltips-popovers.js"></script>



    <!-- Select Plugin Js -->

    <!--<script src="assets/plugins/bootstrap-select/js/bootstrap-select.js"></script> -->



    <!-- Sparkline Chart Plugin Js -->

    <script src="../assets/dashboard/plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <script src="../assets/dashboard/js/jquery-ui.js"></script>

    <script>

          $( function() {

            $( "input.datepicker" ).datepicker({

                dateFormat:'yy-mm-dd',

                changeMonth: true,

                changeYear: true,
                yearRange: '-71:+0'

            });

        } );

    </script>



    <script src="../assets/dashboard/js/select2.min.js"></script>



    <!-- Jquery DataTable Plugin Js -->

    <script src="../assets/dashboard/plugins/jquery-datatable/jquery.dataTables.js"></script>

    <script src="../assets/dashboard/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>

    <script src="../assets/dashboard/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>

    <script src="../assets/dashboard/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>

    <script src="../assets/dashboard/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>

    <script src="../assets/dashboard/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>

    <script src="../assets/dashboard/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>

    <script src="../assets/dashboard/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>

    <script src="../assets/dashboard/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <script src="../assets/dashboard/js/pages/tables/jquery-datatable.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            var overlay = $('.sidebar-overlay');



            $('.sidebar-toggle').on('click', function() {

                var sidebar = $('#sidebar');

                var wrapper = $('.content');

                sidebar.toggleClass('open');

                wrapper.toggleClass('open');

                if ((sidebar.hasClass('sidebar-fixed-left') || sidebar.hasClass('sidebar-fixed-right')) && sidebar.hasClass('open')) {

                    overlay.addClass('active');

                } else {

                    overlay.removeClass('active');

                }

            });



            overlay.on('click', function() {

                $(this).removeClass('active');

                $('#sidebar').removeClass('open');

            });



        });



        

        var jenis =  $("#jenis").val();

        var tgl = $("#tgl").val();

        $('.selectpicker').select2({

            placeholder: 'masukan keyword kode anggota/nama',

            ajax: {

              url: '../master/lokasi.php?user=data&jenistraining='+ jenis +'&tgl='+ tgl,

              dataType: 'json',

              delay: 250,

              processResults: function (data) {

                return {

                  results: data

                };

              },

              cache: true

            }

        });



        $('.selectpickerr').select2({

            placeholder: 'masukan keyword kode anggota/nama',

            ajax: {

              url: '../master/lokasi.php?user=data&jenistraining=training&tgl='+ tgl,

              dataType: 'json',

              delay: 250,

              processResults: function (data) {

                return {

                  results: data

                };

              },

              cache: true

            }

        });

    </script>













