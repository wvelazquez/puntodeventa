<script>
    try {
        onScan.attachTo(document, {
        suffixKeyCodes: [13],
        onScan: function(barcode){
            console.log(barcode)
            window.livewire.emit('scan-code', barcode)
        },
        onScanError: function(e){
            consol.log(e)
            
        }
    })
    console.log('Scanner Ready')
        
    } catch (e) {
        consol.log('Error de lectura: ', e)
    }
</script>