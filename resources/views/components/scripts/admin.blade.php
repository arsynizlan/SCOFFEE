<script>
    // let event_id;

    // // const create = () => {
    // //     $('#createForm').trigger('reset');
    // //     $('#createModal').modal('show');
    // // }


    // const edit = (id) => {
    //     Swal.fire({
    //         title: 'Mohon tunggu',
    //         showConfirmButton: false,
    //         allowOutsideClick: false,
    //         willOpen: () => {
    //             Swal.showLoading()
    //         }
    //     });
    //     event_id = id;

    //     $.ajax({
    //         type: "get",
    //         url: `/events/${event_id}`,
    //         dataType: "json",
    //         success: function(response) {
    //             $('#title-edit').val(response.title);
    //             $('#author-edit').val(response.author);

    //             $('#body-edit').summernote('reset');
    //             $('#body-edit').summernote('editor.pasteHTML', response.body);
    //             $('#body-edit').summernote('disable');

    //             $('#date-edit').val(response.date);
    //             $('#status-edit').val(response.status_publish);


    //             Swal.close();
    //             $('#editModal').modal('show');
    //         }
    //     });

    // }
    // const deleteData = (id) => {
    //     Swal.fire({
    //         title: 'Apa anda yakin untuk menghapus events ini?',
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
    //                 url: `/events/${id}`,
    //                 dataType: "json",
    //                 success: function(response) {
    //                     Swal.close();
    //                     if (response.status) {
    //                         Swal.fire(
    //                             'Success!',
    //                             response.msg,
    //                             'success'
    //                         )
    //                         $('#table').DataTable().ajax.reload();
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
        $('#body-edit').summernote();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });


    //     // $('#createSubmit').click(function(e) {
    //     //     e.preventDefault();

    //     //     var formData = $('#createForm').serialize();

    //     //     Swal.fire({
    //     //         title: 'Mohon tunggu',
    //     //         showConfirmButton: false,
    //     //         allowOutsideClick: false,
    //     //         willOpen: () => {
    //     //             Swal.showLoading()
    //     //         }
    //     //     });

    //     //     $.ajax({
    //     //         type: "post",
    //     //         url: "/category",
    //     //         data: formData,
    //     //         dataType: "json",
    //     //         cache: false,
    //     //         processData: false,
    //     //         success: function(data) {
    //     //             Swal.close();

    //     //             if (data.status) {
    //     //                 Swal.fire(
    //     //                     'Success!',
    //     //                     data.msg,
    //     //                     'success'
    //     //                 )

    //     //                 $('#createModal').modal('hide');
    //     //                 $('#category').DataTable().ajax.reload();
    //     //             } else {
    //     //                 Swal.fire(
    //     //                     'Error!',
    //     //                     data.msg,
    //     //                     'warning'
    //     //                 )
    //     //             }
    //     //         }
    //     //     })
    //     // });

    //     $('#editSubmit').click(function(e) {
    //         e.preventDefault();

    //         var formData = new FormData($('#editForm')[0]);

    //         Swal.fire({
    //             title: 'Mohon tunggu',
    //             showConfirmButton: false,
    //             allowOutsideClick: false,
    //             willOpen: () => {
    //                 Swal.showLoading()
    //             }
    //         });

    //         $.ajax({
    //             type: "post",
    //             url: `/events/${event_id}`,
    //             data: formData,
    //             dataType: "json",
    //             cache: false,
    //             processData: false,
    //             contentType: false,
    //             success: function(data) {
    //                 Swal.close();
    //                 if (data.status) {
    //                     Swal.fire(
    //                         'Success!',
    //                         data.msg,
    //                         'success'
    //                     )

    //                     $('#editModal').modal('hide');
    //                     $('#table').DataTable().ajax.reload();
    //                 } else {
    //                     Swal.fire(
    //                         'Error!',
    //                         data.msg,
    //                         'warning'
    //                     )
    //                 }
    //             }
    //         })
    //     });
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
                url: '/user/all'
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
                    data: 'email',

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
