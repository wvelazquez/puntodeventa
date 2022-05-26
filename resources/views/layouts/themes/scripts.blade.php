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