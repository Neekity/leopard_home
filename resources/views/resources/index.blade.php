@extends('table.index')

@section('content')
    <div class="card">
        <div class="card-head text-right mr-3 mt-3">
            <div class="pull-right">
                {!! Form::button('上传文件', ['class' => 'btn btn-create-resources btn-outline-info',]) !!}
            </div>
        </div>
    </div>
    @parent

    <div class="modal fade" id="resourcesModal" tabindex="-1" role="dialog" aria-labelledby="policyModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 55%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="policyModalLabel">上传资源文件</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-inline" method="post" action="/upload" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="file" name="file">
                            <button type="submit"> 提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script>
        $('.btn-create-resources').click(function () {
            $('#resourcesModal').modal('show');
        });
    </script>
@endsection

