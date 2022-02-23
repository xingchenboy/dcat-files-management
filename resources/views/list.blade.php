<style>
    .files > li {
        float: left;
        width: 150px;
        border: 1px solid #eee;
        margin-bottom: 10px;
        margin-right: 10px;
        position: relative;
    }
    .files>li>.file-select {
        position: absolute;
        top: -4px;
        left: -1px;
    }
    .file-icon {
        text-align: center;
        font-size: 65px;
        color: #666;
        display: block;
        height: 100px;
    }
    .file-info {
        text-align: center;
        padding: 10px;
        background: #f4f4f4;
    }
    .file-name {
        font-weight: bold;
        color: #666;
        display: block;
        overflow: hidden !important;
        white-space: nowrap !important;
        text-overflow: ellipsis !important;
    }
    .file-size {
        color: #999;
        font-size: 12px;
        display: block;
    }
    .files {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .file-icon.has-img {
        padding: 0;
    }
    .file-icon.has-img>img {
         max-width: 100%;
         height: auto;
         max-height: 92px;
     }
</style>

<script data-exec-on-popstate>
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
                        method: 'delete',
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
            if (typeof(data) === 'object') {
                if (data.status) {
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
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
});
</script>

<div class="row">
    <!-- /.col -->
    <div class="col-md-12">
        <div class="box box-primary">

            @include('xingchenboy.dcat-files-management::_toolbar')
            <!-- /.box-body -->
            <div class="box-body file-manager-box">
                @include('xingchenboy.dcat-files-management::_breadcrumb')
                <ul class="files clearfix">

                    @if (empty($list))
                        <li style="height: 200px;border: none;"></li>
                    @else
                        @foreach($list as $item)
                        <li>
                            {!! $item['preview'] !!}

                            <div class="file-info">
                                <a @if(!$item['isDir'])target="_blank"@endif href="{{ $item['link'] }}" class="file-name" title="{{ $item['name'] }}">
                                    {{ $item['icon'] }} {{ basename($item['name']) }}
                                </a>
                                <span class="file-size">
                                  {{ $item['size'] }}&nbsp;

                                    <div class="btn-group btn-group-xs pull-right">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-lg-right">
                                          <button class="dropdown-item file-rename" data-toggle="modal" data-target="#moveModal" data-name="{{ $item['name'] }}">改名&移动</button>
                                          <button class="dropdown-item file-delete" data-path="{{ $item['name'] }}">删除</button>
                                          @unless($item['isDir'])
                                            <a class="dropdown-item" target="_blank" href="{{ $item['download'] }}">下载</a>
                                          @endunless
                                          <button class="dropdown-item" data-toggle="modal" data-target="#urlModal" data-url="{{ $item['url'] }}">路径</button>
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->
</div>

@include('xingchenboy.dcat-files-management::_modal')
