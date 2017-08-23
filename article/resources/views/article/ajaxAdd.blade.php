<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>添加文章</title>
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<style type="text/css">
		body{ font-family: 'Microsoft YaHei';}
		.error{
			color: red;
		}
		/*.panel-body{ padding: 0; }*/
	</style>
</head>
<body>
<div class="jumbotron">
	<div class="container">
		<h1>Laravel 为web艺术家设计</h1>
  		<h3>——我就是玩不转form表单</h3>

	</div>
</div>
<div class="container">
	<div class="main">
		<div class="row">
			<!-- 左侧内容 -->
			<div class="col-md-3">
				<div class="list-group">
					<a href="{{ url('article/index') }}" class="list-group-item text-center
					{{ Request::getPathInfo() == '/article/index'?'active': '' }}">文章列表</a>
					<a href="{{ url('article/add') }}" class="list-group-item text-center
					{{ Request::getPathInfo() == '/article/add'?'active': '' }}">新增文章</a>
					<a href="{{ url('article/ajaxAdd') }}" class="list-group-item text-center
					{{ Request::getPathInfo() == '/article/ajaxAdd'?'active': '' }}">Ajax新增文章</a>
				</div>
			</div>
			<!-- 右侧内容 -->
			<div class="col-md-9">
				@if(count($errors))
				<!-- 错误提示 -->
				<div class="alert alert-danger" role="alert">
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
						{{--<li>内容不能为空</li>--}}
					</ul>
				</div>
				@endif
				<!-- 自定义内容 -->
				<div class="panel panel-default">
					<div class="panel-heading">新增文章</div>
					<div class="panel-body">
						<form class="form-horizontal" id="form_article" role="form" method="post" action="">
							{{ csrf_field() }}
							<div class="form-group">
								<label class="col-sm-2 control-label">标题</label>
								<div class="col-sm-5">
									<input type="text" class="form-control"
										   data-rule-required="true"
										   data-msg-required="请输入文章标题"
										   data-rule-minlength="5"
										   data-msg-minlength="文章标题长度最小为5"
										   placeholder="标题" id="title" name="Article[title]" value="{{ old('Article.title') }}">
								</div>
								<div class="col-sm-5">
									<p class="form-control-static text-danger">{{ $errors->first('Article.title') }}</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">内容</label>
								<div class="col-sm-5">
									<textarea class="form-control"
									data-rule-required="true"
									data-msg-required="请输入文章内容"
									placeholder="内容" id="content" name="Article[content]">{{ old('Article.content') }}</textarea>
								</div>
								<div class="col-sm-5">
									<p class="form-control-static text-danger">{{ $errors->first('Article.content') }}</p>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="button" class="btn btn-primary">ajax提交</button>
								</div>
							</div>
						</form>

					</div>
				</div>


			</div>
		</div>
  	</div>
</div>
<!-- 尾部 -->
<div class="jumbotron" style=" margin-bottom:0;margin-top:105px;">
	<div class="container">
	<span>&copy; 2016 Saitmob</span>
	</div>
</div>

<script src="{{ asset('js/jquery-3.1.0.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/messages_zh.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script>

    $('.btn-primary').click(function(){
        $.ajax({
            type: 'post',
            dataType: 'JSON',
            data: $('form').serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            success: function(data){
                alert(data.msg);
                if(data.status){
                    window.location.href = '{{ url("article/index") }}';
				}
            },
            error : function (XMLHttpRequest, textStatus) {
                var ret_code = XMLHttpRequest.status;
                var ret_json = XMLHttpRequest.responseJSON;
                var message = {};
                var message_show = '';
                for( var i in ret_json){
                    message[i] = ret_json[i][0];
                    message_show += message[i]+"\r\n";
                }
                if( ret_code == 422 ){
                    for( var p in $('form').serializeArray()){
                        if(message[p]){
                            var responseObject = {status:false,message:message[p]};break;
                        }
                    }

                }else if(textStatus == 'error') {
                    var responseObject = {status:false,message:'请求失败'};
                }
//                console.log(message);
                alert(message_show);
            }
        });
	});

    $().ready(function() {
		// 在键盘按下并释放及提交后验证提交表单
        $("#form_article").validate();
    });
</script>
</body>
</html>