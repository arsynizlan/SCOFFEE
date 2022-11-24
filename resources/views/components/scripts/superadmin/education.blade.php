<script>
    let education_id;

    // const create = () => {
    //     $(".dropify-clear").click();
    //     $('#createForm').trigger('reset');
    //     $('#description').summernote('reset');
    //     $('#description').summernote();
    //     $('#createModal').modal('show');
    // }

    const info = (id) => {

        Swal.fire({
            title: 'Mohon tunggu',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading()
            }
        });
        education_id = id;

        $.ajax({
            type: "get",
            url: `/education/${education_id}`,
            dataType: "json",
            success: function(response) {

                $('#title-info').val(response.title).attr("readonly", true);
                $('#category-info').val(response.category).attr("disabled", true);
                $('#body-info').summernote('code', response.body);
                $('#body-info').summernote('disable');

                Swal.close();
                $('#infoModal').modal('show');
            }
        });
    }




    const deleteData = (id) => {
        Swal.fire({
            title: 'Apa anda yakin untuk menghapus kopi ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            Swal.close();

            if (result.value) {
                Swal.fire({
                    title: 'Mohon tunggu',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    willOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    type: "delete",
                    url: `/education/${id}`,
                    dataType: "json",
                    success: function(response) {
                        Swal.close();
                        if (response.status) {
                            Swal.fire(
                                'Success!',
                                response.msg,
                                'success'
                            )
                            $('#table').DataTable().ajax.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                response.msg,
                                'warning'
                            )
                        }
                    }
                });
            }
        });
    }


    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });


        $('#table').DataTable({
            dom: 'Bfrtip',
            // Configure the drop down options.
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            buttons: [
                'pageLength', 'excel', 'pdf', 'print'
            ],
            filter: true,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {
                url: '/education/list',
            },
            "columns": [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',

                },
                {
                    data: 'author',

                },
                {
                    data: 'category',

                },
                {
                    data: 'image',

                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                },

            ]
        });
    });
</script>
