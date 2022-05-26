<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset ('bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset ('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset ('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="{{ asset ('plugins/apex/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/dash_2.js') }}"></script>

<script>
    function noty(msg, option = 1)
    {
        Snackbar.show({
            text:msg.toUpperCase(),
            actionText: 'CERRAR',
            actionTextColor: '#fff', 
            backgroundColor: option == 1 ? '#3b3f5c' : '#e7515a',
            pos: 'top-rigth'
        });
    }
</script>

@livewireScripts 