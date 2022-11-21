<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
    integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(function() {
        $('#createImage').dropify({
            messages: {
                'default': 'Masukan Gambar',
                'replace': 'Drag and drop atau click untuk mengganti',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });
        $('.dropify-clear').click();
    });
</script>
