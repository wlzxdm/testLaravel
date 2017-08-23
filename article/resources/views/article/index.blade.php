<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>文章列表</title>
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<style type="text/css">
		body{ font-family: 'Microsoft YaHei';}
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
					{{ in_array(Request::getPathInfo(),['/article/index','/article'])?'active': '' }}
					">文章列表</a>
					<a href="{{ url('article/add') }}" class="list-group-item text-center
					{{ Request::getPathInfo() == '/article/add'?'active': '' }}
					">新增文章</a>
				</div>
			</div>
			<!-- 右侧内容 -->
			<div class="col-md-9">
				@if(Session::has('success'))
					<!-- 成功提示框 -->
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>成功！</strong> {{ Session::get('success') }}
					</div>
					@endif
				@if(Session::has('error'))
					<!-- 失败提示框 -->
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>失败！</strong> {{ Session::get('error') }}
					</div>
				@endif
				<!-- 自定义内容 -->
				<div class="panel panel-default">
					<div class="panel-heading">文章列表</div>
					<div class="panel-body">
						<table class="table table-striped table-responsive table-hover">
							<thead>
								<tr>
									<th>id</th>
									<th>标题</th>
									<th>内容</th>
									<th>添加时间</th>
									<th>修改时间</th>
									<th width="120">操作</th>
								</tr>
							</thead>
							<tbody>
							@foreach($arts as $item)
								<tr>
									<th>{{ $item->id }}</th>
									<td>{{ $item->title }}</td>
									<td>{{ $item->content }}</td>
									<td>{{ $item->created_at }}</td>
									<td>{{ $item->updated_at }}</td>
									<td>
										{{--<a href="">详情</a>--}}
										<a href="{{ url('article/update',['id' => $item->id]) }}">修改</a>
										<a href="{{ url('article/del',['id' => $item->id]) }}" onclick="if(confirm('是否确认删除？') == false){return false;}">删除</a>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
				
				<nav>
					<ul class="pull-right">
						{{ $arts->render() }}
					</ul>
				</nav>	
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
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>