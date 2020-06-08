

    <div class="panel-body">
        <form method="post" action="/upload" enctype="multipart/form-data" >
            {{ csrf_field() }}
            <input type="file" name="file">
            <button type="submit"> 提交 </button>
        </form>
    </div>




