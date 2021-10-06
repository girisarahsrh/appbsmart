 <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="/Assets/assets/libs/jquery/dist/jquery.min.js "></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="/Assets/assets/libs/popper.js/dist/umd/popper.min.js "></script>
    <script src="/Assets/assets/libs/bootstrap/dist/js/bootstrap.min.js "></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->

    <script src="/Assets/dist/js/app-style-switcher.js"></script>
    <script src="/Assets/dist/js/feather.min.js"></script>
    <script src="/Assets/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="/Assets/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="/Assets/dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <script src="/Assets/assets/extra-libs/c3/d3.min.js"></script>
    <script src="/Assets/assets/extra-libs/c3/c3.min.js"></script>
    {{-- <script src="/Assets/assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="/Assets/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script> --}}
    <script src="/Assets/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="/Assets/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/Assets/dist/js/pages/dashboards/dashboard1.min.js"></script>
    <script src="/Assets/assets/extra-libs/select2/select2.min.js"></script>
    <script src="/Assets/assets/extra-libs/datatablesnet/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>
    <script src="/Assets/assets/dist/js/pages/datatable/datatable-basic.init.js"></script>
    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ============================================================== -->
    <script>
        $(".preloader ").fadeOut();

        function setValueElement(element, value, trigger) {
      // $('#DIKMIL').val(null).trigger('change');
      $(element).val(value).trigger(trigger);
    }

    var session_satker_id = "{{session()->get('pegawai_satker_id')}}"
    var session_rule_id = "{{session()->get('pegawai_rule_id')}}"


    </script>
</body>

</html>