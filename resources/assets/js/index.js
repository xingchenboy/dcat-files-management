$(function () {
    $('.file-delete').click(function () {
        var path = $(this).data('path');
        swal.fire({
            title: "{{ trans('admin.delete_confirm') }}",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{ trans('admin.confirm') }}",
            showLoaderOnConfirm: true,
            cancelButtonText: "{{ trans('admin.cancel') }}",
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        method: "delete",
                        url: "{{ $url['delete'] }}",
                        data: {
                            'files[]':[path],
                            // _token:LA.token
                        },
                        success: function (data) {
                            $.pjax.reload('#pjax-container');
                            resolve(data);
                        }
                    });
                });
            }
        }).then(function(result){
            var data = result.value;
            if (typeof data === 'object') {
                if (data.status) {
                    swal(data.message, '', 'success');
                } else {
                    swal(data.message, '', 'error');
                }
            }
        });
    });
    $('#moveModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var name = button.data('name');
        var modal = $(this);
        modal.find('[name=path]').val(name)
        modal.find('[name=new]').val(name)
    });
    $('#urlModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url = button.data('url');
        $(this).find('input').val(url)
    });
    $('#file-move').on('submit', function (event) {
        event.preventDefault();
        var form = $(this);
        var path = form.find('[name=path]').val();
        var name = form.find('[name=new]').val();
        $.ajax({
            method: 'put',
            url: "{{ $url['move'] }}",
            data: {
                path: path,
                'new': name,
                // _token:LA.token,
            },
            success: function (data) {
                $.pjax.reload('#pjax-container');
                if (typeof data === 'object') {
                    if (data.status) {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                }
            }
        });
        closeModal();
    });
    $('.file-upload').on('change', function () {
        $('.file-upload-form').submit();
    });
    $('#new-folder').on('submit', function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            method: 'POST',
            url: "{{ $url['new-folder'] }}",
            data: formData,
            async: false,
            success: function (data) {
                $.pjax.reload('#pjax-container');
                if (typeof data === 'object') {
                    if (data.status) {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        closeModal();
    });
    function closeModal() {
        $("#moveModal").modal('toggle');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
    $('.media-reload').click(function () {
        $.pjax.reload('#pjax-container');
    });
    $('.goto-url button').click(function () {
        var path = $('.goto-url input').val();
        $.pjax({container:'#pjax-container', url: "{{ $url['index'] }}?path=" + path });
    });
    $('.file-delete-multiple').click(function () {
        var files = $(".file-select input:checked").map(function(){
            return $(this).val();
        }).toArray();
        if (!files.length) {
            return;
        }
        swal.fire({
            title: "{{ trans('admin.delete_confirm') }}",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{ trans('admin.confirm') }}",
            showLoaderOnConfirm: true,
            cancelButtonText: "{{ trans('admin.cancel') }}",
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        method: 'delete',
                        url: "{{ $url['delete'] }}",
                        data: {
                            'files[]': files,
                            // _token:LA.token
                        },
                        success: function (data) {
                            $.pjax.reload('#pjax-container');
                            resolve(data);
                        }
                    });
                });
            }
        }).then(function (result) {
            var data = result.value;
            if (typeof data === 'object') {
                if (data.status) {
                    swal(data.message, '', 'success');
                } else {
                    swal(data.message, '', 'error');
                }
            }
        });
    });
    $('table>tbody>tr').mouseover(function () {
        $(this).find('.btn-group').removeClass('hide');
    }).mouseout(function () {
        $(this).find('.btn-group').addClass('hide');
    });
});
