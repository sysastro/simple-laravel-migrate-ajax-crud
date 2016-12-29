@extends('layouts.migrate')
@section('scripts')
    <script>
        $(document).on('click', '#submit-news', function (e) {
            var me = $(this);

            e.preventDefault();
            if ( me.data('requestRunning') ) {
                return;
            }
            me.data('requestRunning', true);

            $.ajax({
                url: "{{ url('/news/create') }}",
                method: "POST",
                data: $('#add-news').serialize(),
                dataType: "json",
                success: function(data) {
                    if(data['status'] == "success"){
                        $("#error-information").html(
                                '<div class="alert alert-success">' +
                                '<strong>Success</strong> Submit form request success.' +
                                '</div>'
                        );
                        $("#add-news").trigger('reset');
                        reloadListNews();
                    } else {
                        $("#error-information").html(
                                '<div class="alert alert-danger">' +
                                '<strong>Error !</strong> Submit form request error.' +
                                '</div>'
                        );
                    }
                },
                error: function(xhr){
                    $("#error-information").html(
                            '<div class="alert alert-danger">' +
                            '<strong>Error !</strong> Submit form request error.' +
                            '</div>'
                    );
                },
                complete: function() {
                    me.data('requestRunning', false);
                }
            });
        });

        $(document).on('click', '#btn-delete', function (e) {
            var confirmation = confirm('Are you sure to delete this data ?');
            var id = $(this).data('id');
            $object = $(this);

            var me = $(this);
            e.preventDefault();
            if (me.data('requestRunning')) {
                return;
            }
            me.data('requestRunning', true);

            if (confirmation == true) {
                $.ajax({
                    url: "{{ url('/news/delete/') }}" + "/" + id,
                    method: "GET",
                    dataType: "json",
                    success: function(data) {
                        if(data['status'] == "success"){
                            $("#error-information").html(
                                    '<div class="alert alert-success">' +
                                    '<strong>Success</strong> Delete data success.' +
                                    '</div>'
                            );
                            $($object).parents('tr').remove();
                        } else {
                            $("#error-information").html(
                                    '<div class="alert alert-danger">' +
                                    '<strong>Success</strong> Delete data failed.' +
                                    '</div>'
                            );
                        }
                    },
                    complete: function() {
                        me.data('requestRunning', false);
                    }
                });
            }
            else
            {
                return false;
            }
        });

        $(document).on('click', '#btn-edit', function (e) {
            var id = $(this).data('id');
            $object = $(this);

            var me = $(this);
            e.preventDefault();
            if (me.data('requestRunning')) {
                return;
            }
            me.data('requestRunning', true);

                $.ajax({
                    url: "{{ url('/news/get/') }}" + "/" + $.base64.encode(id),
                    method: "GET",
                    dataType: "json",
                    success: function(data) {
                        if(data['uuid'] !== undefined){
                            $('#submit-news').hide();
                            $('#update-news').show();
                            $('#cancel-news').show();

                            $('#uuid').val(data['uuid']);
                            $('#title').val(data['title']);
                            $('#slug').val(data['slug']);
                            $('#content').val(data['content']);
                            $('#visitor').val(data['visitor']);
                            $('#news-id').val(data['id']);
                            (data['is_active'] == 1 ? $('#is_active').prop('checked', true) : $('#is_active').prop('checked', false));
                        } else {
                            $("#error-information").html(
                                    '<div class="alert alert-danger">' +
                                    '<strong>Error</strong> Data not found.' +
                                    '</div>'
                            );
                        }
                    },
                    complete: function() {
                        me.data('requestRunning', false);
                    }
                });
        });

        $(document).on('click', '#update-news', function (e) {
            var me = $(this);

            e.preventDefault();
            if ( me.data('requestRunning') ) {
                return;
            }
            me.data('requestRunning', true);

            $.ajax({
                url: "{{ url('/news/update') }}",
                method: "POST",
                data: $('#add-news').serialize(),
                dataType: "json",
                success: function(data) {
                    if(data['status'] == "success"){
                        $("#error-information").html(
                                '<div class="alert alert-success">' +
                                '<strong>Success</strong> Update form request success.' +
                                '</div>'
                        );
                        $("#add-news").trigger('reset');
                        reloadListNews();
                    } else {
                        $("#error-information").html(
                                '<div class="alert alert-danger">' +
                                '<strong>Error !</strong> Update form request error.' +
                                '</div>'
                        );
                    }
                },
                error: function(xhr){
                    $("#error-information").html(
                            '<div class="alert alert-danger">' +
                            '<strong>Error !</strong> Update form request error.' +
                            '</div>'
                    );
                },
                complete: function() {
                    me.data('requestRunning', false);
                }
            });
        });

        $(document).on('click', '#cancel-news', function (e) {
            e.preventDefault();
            var me = $(this);
            if (me.data('requestRunning')) {
                return;
            }
            me.data('requestRunning', true);

            $('#submit-news').show();
            $('#update-news').hide();
            $('#cancel-news').hide();
            $("#add-news").trigger('reset');

            me.data('requestRunning', false);
        });

        function reloadListNews()
        {
            $.ajax({
                url: "{{ url('/news/data') }}",
                method: "GET",
                beforeSend: function() {
                    $('#listnewsdata').html('<tr><td colspan="6">Loading...</td></tr>');
                    $("#error-information").html(
                            '<div class="alert alert-info">' +
                            '<strong>Loading...</strong>' +
                            '</div>'
                    );
                },
                success: function(data) {
                    $('#listnewsdata').html('');
                    $("#error-information").html('');
                    if(data.length > 0){
                        for(idx=0; idx<=(data.length - 1); idx++) {
                            $('#listnewsdata').append(
                                    '<tr>' +
                                    '<td>' + data[idx]['uuid'] + '</td>' +
                                    '<td>' + data[idx]['title'] + '</td>' +
                                    '<td>' + data[idx]['slug'] + '</td>' +
                                    '<td>' + data[idx]['content'] + '</td>' +
                                    '<td>' + data[idx]['visitor'] + '</td>' +
                                    '<td>' + (data[idx]['is_active'] == 1 ? 'Yes' : 'No') + '</td>' +
                                    '<td>' + '<button class="btn btn-info btn-sm" id="btn-edit" data-id="' + data[idx]['uuid'] + '"><span class="glyphicon glyphicon-edit"></span> </button> &nbsp;' +
                                    '<button class="btn btn-danger btn-sm" id="btn-delete" data-id="' + data[idx]['uuid'] + '"><span class="glyphicon glyphicon-trash"></span> </button>' + '</td>' +
                                    '</td>'
                            );
                        }
                    }else{
                        $('#listnewsdata').append('<tr><td colspan="6">No data found.</td></tr>');
                    }
                }
            });
        }
        $(document).ready(function() {
            reloadListNews();
        });
    </script>
@stop
<div class="row">
    <div class="col-lg-offset-3 col-lg-3">
        <h4>Form Add News</h4>
        <form method="post" id="add-news">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="news-id">
            <div class="form-group col-lg-12" id="error-information">

            </div>
            <div class="form-group col-lg-12">
                <label>UUID</label>
                <input type="text" class="form-control" name="uuid" id="uuid">
            </div>
            <div class="form-group col-lg-12">
                <label>Title</label>
                <input type="text" class="form-control" name="title" id="title">
            </div>
            <div class="form-group col-lg-12">
                <label>Slug</label>
                <input type="text" class="form-control" name="slug" id="slug">
            </div>
            <div class="form-group col-lg-12">
                <label>Content</label>
                <input type="text" class="form-control" name="content" id="content">
            </div>
            <div class="form-group col-lg-12">
                <label>Visitor</label>
                <input type="text" class="form-control" name="visitor" id="visitor">
            </div>
            <div class="form-group col-lg-12">
                <label>Is Active</label>
                <input type="checkbox" name="is_active" value="1" id="is_active">
            </div>
            <div class="form-group col-lg-12">
                <button id="submit-news" class="btn btn-sm btn-success">Submit</button>
                <button id="update-news" class="btn btn-sm btn-success" style="display: none;">Update</button>
                <button id="cancel-news" class="btn btn-sm btn-info" style="display: none;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-offset-3 col-lg-6">
        <h4>List News</h4>
        <table class="table table-bordered">
            <thead>
                <th>UUID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Content</th>
                <th>Visitor</th>
                <th>Is Active</th>
                <th>Option</th>
            </thead>
            <tbody id="listnewsdata">

            </tbody>
        </table>

    </div>
</div>