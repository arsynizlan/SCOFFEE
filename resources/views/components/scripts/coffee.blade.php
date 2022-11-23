<script>
    let coffee_id;

    const create = () => {
        $(".dropify-clear").click();
        $('#createForm').trigger('reset');
        $('#createModal').modal('show');
    }

    const info = (id) => {

        Swal.fire({
            title: 'Mohon tunggu',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading()
            }
        });
        coffee_id = id;

        $.ajax({
            type: "get",
            url: `/coffee/${coffee_id}`,
            dataType: "json",
            success: function(response) {

                $('#name-info').val(response.name);
                $("#name-info").attr("readonly", true)
                $('#origin-info').val(response.origin);
                $("#origin-info").attr("readonly", true)
                $('#type-info').val(response.type);
                $("#type-info").attr("readonly", true)
                $('#description-info').summernote('code', response.description);
                $('#description-info').summernote('disable');
                $('#story-info').summernote('code', response.story);
                $('#story-info').summernote('disable');

                Swal.close();
                $('#infoModal').modal('show');
            }
        });
    }


    const edit = (id) => {
        Swal.fire({
            title: 'Mohon tunggu',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading()
            }
        });
        coffee_id = id;

        $.ajax({
            type: "get",
            url: `/coffee/${id}`,
            dataType: "json",
            success: function(response) {
                $('#name-edit').val(response.name);
                $('#origin-edit').val(response.origin);
                $('#type-edit').val(response.type);
                $('#description-edit').summernote('code', response.description);
                $('#story-edit').summernote('code', response.story);

                Swal.close();
                $('#editModal').modal('show');
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
                    url: `/coffee/${id}`,
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
        $('#description').summernote();

        $('#story').summernote();



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });


        $('#createSubmit').click(function(e) {
            e.preventDefault();

            var formData = new FormData($('#createForm')[0]);

            Swal.fire({
                title: 'Mohon tunggu',
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                type: "post",
                url: "/coffee",
                data: formData,
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    Swal.close();

                    if (data.status) {
                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                        )
                        $('#createModal').modal('hide');
                        $('#table').DataTable().ajax.reload();
                    } else {
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'warning'
                        )
                    }
                }
            });
        });

        $('#editSubmit').click(function(e) {
            e.preventDefault();

            var formData = new FormData($('#editForm')[0]);

            Swal.fire({
                title: 'Mohon tunggu',
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({

                type: "post",
                url: `/coffee/${coffee_id}`,
                data: formData,
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    Swal.close();
                    if (data.status) {
                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                        )

                        $('#editModal').modal('hide');
                        $('#table').DataTable().ajax.reload();
                    } else {
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'warning'
                        )
                    }
                }
            })
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
                url: '/coffee/listcoffee',
            },
            "columns": [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',

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
