<script>
    // let category_id;

    // const create = () => {
    //     $('#createForm').trigger('reset');
    //     $('#createModal').modal('show');
    // }
    // const importData = () => {
    //     $('#importProduct').trigger('reset');
    //     $('#importModal').modal('show');
    // }
    // const edit = (id) => {
    //     Swal.fire({
    //         title: 'Mohon tunggu',
    //         showConfirmButton: false,
    //         allowOutsideClick: false,
    //         willOpen: () => {
    //             Swal.showLoading()
    //         }
    //     });
    //     category_id = id;

    //     $.ajax({
    //         type: "get",
    //         url: `/category/${category_id}`,
    //         dataType: "json",
    //         success: function(response) {
    //             $('#name-edit').val(response.name);

    //             Swal.close();
    //             $('#editModal').modal('show');
    //         }
    //     });

    // }
    // const deleteData = (id) => {
    //     Swal.fire({
    //         title: 'Apa anda yakin untuk menghapus kategori ini?',
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: 'Ya',
    //         cancelButtonText: 'Tidak'
    //     }).then((result) => {
    //         Swal.close();

    //         if (result.value) {
    //             Swal.fire({
    //                 title: 'Mohon tunggu',
    //                 showConfirmButton: false,
    //                 allowOutsideClick: false,
    //                 willOpen: () => {
    //                     Swal.showLoading()
    //                 }
    //             });

    //             $.ajax({
    //                 type: "delete",
    //                 url: `/category/${id}`,
    //                 dataType: "json",
    //                 success: function(response) {
    //                     Swal.close();
    //                     if (response.status) {
    //                         Swal.fire(
    //                             'Success!',
    //                             response.msg,
    //                             'success'
    //                         )
    //                         $('#category').DataTable().ajax.reload();
    //                     } else {
    //                         Swal.fire(
    //                             'Error!',
    //                             response.msg,
    //                             'warning'
    //                         )
    //                     }
    //                 }
    //             });
    //         }
    //     });

    // }
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });


        // $('#createSubmit').click(function(e) {
        //     e.preventDefault();

        //     var formData = $('#createForm').serialize();

        //     Swal.fire({
        //         title: 'Mohon tunggu',
        //         showConfirmButton: false,
        //         allowOutsideClick: false,
        //         willOpen: () => {
        //             Swal.showLoading()
        //         }
        //     });

        //     $.ajax({
        //         type: "post",
        //         url: "/category",
        //         data: formData,
        //         dataType: "json",
        //         cache: false,
        //         processData: false,
        //         success: function(data) {
        //             Swal.close();

        //             if (data.status) {
        //                 Swal.fire(
        //                     'Success!',
        //                     data.msg,
        //                     'success'
        //                 )

        //                 $('#createModal').modal('hide');
        //                 $('#category').DataTable().ajax.reload();
        //             } else {
        //                 Swal.fire(
        //                     'Error!',
        //                     data.msg,
        //                     'warning'
        //                 )
        //             }
        //         }
        //     })
        // });
        // $('#editSubmit').click(function(e) {
        //     e.preventDefault();

        //     var formData = $('#editForm').serialize();

        //     Swal.fire({
        //         title: 'Mohon tunggu',
        //         showConfirmButton: false,
        //         allowOutsideClick: false,
        //         willOpen: () => {
        //             Swal.showLoading()
        //         }
        //     });

        //     $.ajax({
        //         type: "post",
        //         url: `/category/${category_id}`,
        //         data: formData,
        //         dataType: "json",
        //         cache: false,
        //         processData: false,
        //         success: function(data) {
        //             Swal.close();
        //             if (data.status) {
        //                 Swal.fire(
        //                     'Success!',
        //                     data.msg,
        //                     'success'
        //                 )
        //                 category_id = null;
        //                 $('#editModal').modal('hide');
        //                 $('#category').DataTable().ajax.reload();
        //             } else {
        //                 Swal.fire(
        //                     'Error!',
        //                     data.msg,
        //                     'warning'
        //                 )
        //             }
        //         }
        //     })
        // });
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
                url: '/events/all'
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
                    data: 'status_publish',
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
