<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>bridgeafrica.</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../assets/img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="../assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/atlantis.min.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="../assets/css/demo.css">
</head>
<body>
	<div class="wrapper">

        @include('topbar')
<!-- Sidebar -->
        @include('navbar')
<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">bridgeafrica</h2>
								<h5 class="text-white op-7 mb-2">bridgeafrica</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
									
									<a class="btn btn-white btn-border btn-round mr-2" data-close="true" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
										{{ __('logout') }}
										<i class="fa fa-power"></i>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
										@csrf
									</form>
									</a>
								<a href="#" class="btn btn-secondary btn-round">Add Customer</a>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-6">
							<div class="card full-height shadow">
								<div class="card-body">
									<div class="card-title">Overall statistics</div>
									<div class="card-category">Daily information about statistics in system</div>
									<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-1"></div>
											<h6 class="fw-bold mt-3 mb-0">New Product</h6>
										</div>
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-2"></div>
											<h6 class="fw-bold mt-3 mb-0">product</h6>
										</div>
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-3"></div>
											<h6 class="fw-bold mt-3 mb-0">User</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card full-height shadow">
								<div class="card-body">
									<div class="card-title">Total statistics</div>
									<div class="row py-3">
										<div class="col-md-4 d-flex flex-column justify-content-around">
											<div>
												<h6 class="fw-bold text-uppercase text-success op-8">Total Income</h6>
												<h3 class="fw-bold">$
													@php
														$it = 0;
														$t = DB::select('select price_min from product ');
														foreach ($t as $key) {
															$it += $key->price_min;
														}
													@endphp
													{{ number_format($it) }} XAF
												</h3>
											</div>
											<div>
												<h6 class="fw-bold text-uppercase text-danger op-8">Total Depense </h6>
												<h3 class="fw-bold">$
													
												</h3>
											</div>
										</div>
										<div class="col-md-8">
											<div id="chart-container">
												<canvas id="totalIncomeChart"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row row-card-no-pd">
						<div class="col-md-12">
							@if (session('add_family'))
							<div class="col-lg-12 col-md-12">
								<div class="card product_item_list">
									<div class="body table-responsive shadow">
										<div class="alert alert-success" role="alert">
											{{ session('add_family') }}
										</div>
									</div>
								</div>
							</div>
							@endif
							<div class="row">
								<div class="col-lg-4 col-md-6 col-sm-12 ">
									<div class="card product_item_list">
										<div class="body table-responsive shadow">
											<div class="card-body card product_item_list responsive-mg-b-30 ">
												<div class="panel-body center">
													<center>
														<img src="{{asset('images/image-gallery/Finance.png')}}" class="img-circle center m-b img-responsive" width="90" alt="User"/>
													</center>
													<br>
													<div class="list" style="margin-left: 1%;list-style:none;">
														<p class="m-b-0 margin10 padding p12">
															<center>
																<table style="text-align: center;">
																	<th> Les Differentes Familles de Produits</th>
																</table>
															</center>
														</p>
													</div>
													<div class="">
														<div class="">
															@php
																$famille = DB::select('select all_familly from list_product ');
															@endphp
														@foreach ($famille as $item)
														<div class="col-lg-12 col-md-12 col-sm-12">
															<h5 class="text-justify font-15">
																<table class="table table-responsive responsive">
																	<thead>
																		<tr>
																			<th>LA FAMILLE </th>
																			<th>ACRONYME </th>
																		</tr>
																	</thead>
																	<tbody>
																		@php
																			$question = json_decode(($item->all_familly), true);
																			$count = count($question);
																		@endphp
																		@for ($i = 0; $i < $count; $i++)
																		<tr>
																			<td class="color-grey review-text font-italic m-0">{{ $question[$i]}}</td>
																			<td>
																				@php
																					$arr_0= explode(' ',trim($question[$i]));
																					if (count($arr_0)> 1) {
																					$output_ = $arr_0[0];
																					$output_0 = $arr_0[1];
																					echo strtoupper($output_[0]).strtoupper($output_0[0]);
																					}else {
																						echo strtoupper($question[$i][0]).strtoupper($question[$i][1]);
																					}
																				@endphp
																			</td>
																		</tr>
																		@endfor
																	</tbody>
																</table>
															</h5>
														</div>
														@endforeach
														</div>
													</div>
													<a href="javascript:void()" class="btn btn-primary btn-lg btn-block" onclick="add_family()">Cliquez pour Ajouter une famillle</a>
													<form action="{{ route('form_add_family') }}" method="GET" enctype="multipart/form-data" class="form-horizontal" role="form" id="form_add_family" style="display: none;">
														{{ csrf_field() }}
														<div class="form-group">
															<label class="col-md-10 control-label">Ajouter une famille ici</label>
																<input type="text" class="form-input input form-control" name="add_family" id="add_family"/>
														</div>
														<div class="col-md-10 col-md-offset-4">
															<button type="submit" class="btn btn-success btn-block">
																<i class="fa fa-btn fa-sign-in"></i>Ajouter
															</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-6 col-sm-12 ">
									<div class="card product_item_list">
										<div class="body table-responsive shadow">
											<div class="card-body card product_item_list responsive-mg-b-30 ">
												<div class="panel-body center">
													<center>
														<img src="{{asset('images/image-gallery/Finance.png')}}" class="img-circle center m-b img-responsive" width="90" alt="User"/>
													</center>
													<br>
													<div class="list" style="margin-left: 1%;list-style:none;">
														<p class="m-b-0 margin10 padding p12">
															<center>
																<table style="text-align: center;">
																	<th> Les Differents Types de Produits</th>
																</table>
															</center>
														</p>
													</div>
													<div class="">
														<div class="">
															@php
																$all_type  = DB::select('select all_type from list_product ');
															@endphp
														@foreach ($all_type  as $item_all_type)
														<div class="col-lg-12 col-md-12 col-sm-12">
															<h5 class="text-justify font-15">
																<table class="table table-responsive responsive">
																	<thead>
																		<tr>
																			<th>LA FAMILLE </th>
																			<th>ACRONYME </th>
																		</tr>
																	</thead>
																	<tbody>
																		@php
																			$type = json_decode(($item_all_type->all_type), true);
																			$count_type = count($type);
																		@endphp
																		@for ($i_type = 0; $i_type < $count_type; $i_type++)
																		<tr>
																			<td class="color-grey review-text font-italic m-0">{{ $type[$i_type]}}</td>
																			<td>
																				@php
																					$arr_1= explode(' ',trim($type[$i_type]));
																					if (count($arr_1)> 1) {
																					$output_1 = $arr_1[0];
																					$output_2 = $arr_1[1];
																					echo strtoupper($output_1[0]).strtoupper($output_2[0]);
																					}else {
																						echo strtoupper($type[$i_type][0]).strtoupper($type[$i_type][1]);
																					}
																				@endphp
																				@php
																					//$arr_1= explode(' ',trim($type[$i_type]));
																					//$output_1 = $arr_1[0];
																					//$output_2 = $arr_1[1];
																				@endphp
																				{{ strtoupper(' ')/*.strtoupper($output_2[0])*/}}
																			</td>
																		</tr>
																		@endfor
																	</tbody>
																</table>
															</h5>
														</div>
														@endforeach
														</div>
													</div>
													<a href="javascript:void()" class="btn btn-primary btn-lg btn-block" onclick="add_type()">Cliquez pour Ajouter un Type</a>
													<form action="{{ route('form_add_type') }}" method="GET" enctype="multipart/form-data" class="form-horizontal" role="form" id="form_add_type" style="display: none;">
														{{ csrf_field() }}
														<div class="form-group">
															<label class="col-md-10 control-label">Ajouter un Type ici</label>
																<input type="text" class="form-input input form-control" name="add_type" id="add_type"/>
														</div>
														<div class="col-md-10 col-md-offset-4">
															<button type="submit" class="btn btn-success">
																<i class="fa fa-btn fa-sign-in"></i>Ajouter
															</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-6 col-sm-12 ">
									<div class="card product_item_list">
										<div class="body table-responsive shadow">
											<div class="card-body card product_item_list responsive-mg-b-30 ">
												<div class="panel-body center">
													<center>
														<img src="{{asset('images/image-gallery/Finance.png')}}" class="img-circle center m-b img-responsive" width="90" alt="User"/>
													</center>
													<br>
													<div class="list" style="margin-left: 1%;list-style:none;">
														<p class="m-b-0 margin10 padding p12">
															<center>
																<table style="text-align: center;">
																	<th> Les Differentes Cat&eacute;gories de Produits</th>
																</table>
															</center>
														</p>
													</div>
													<div class="">
														<div class="">
															@php
																$Cat = DB::select('select all_categorie from list_product ');
															@endphp
														@foreach ($Cat as $item_Cat)
														<div class="col-lg-12 col-md-12 col-sm-12">
															<h5 class="text-justify font-15">
																<table class="table table-responsive responsive">
																	<thead>
																		<tr>
																			<th>LA FAMILLE </th>
																			<th>ACRONYME </th>
																		</tr>
																	</thead>
																	<tbody>
																		@php
																			$_Cat = json_decode(($item_Cat->all_categorie), true);
																			$count_Cat = count($_Cat);
																		@endphp
																		@for ($i_Cat = 0; $i_Cat < $count_Cat; $i_Cat++)
																		<tr>
																			<td class="color-grey review-text font-italic m-0">{{ $_Cat[$i_Cat]}}</td>
																			<td>
																				@php
																					//$condition2 = ctype_space($_Cat[$i_Cat]);
																					$arr_3= explode(' ',trim($_Cat[$i_Cat]));
																					if (count($arr_3)> 1) {
																					$output_3 = $arr_3[0];
																					$output_4 = $arr_3[1];
																					echo strtoupper($output_3[0]).strtoupper($output_4[0]);
																					}else {
																						//$arr_3= explode(' ',trim($_Cat[$i_Cat]));
																						//$output_3= $arr_3[0];
																						//echo strtoupper($output_3[0]).strtoupper($output_3[1]);
																						echo strtoupper($_Cat[$i_Cat][0]).strtoupper($_Cat[$i_Cat][1]);;
																					}
																				@endphp
																			</td>
																		</tr>
																		@endfor
																	</tbody>
																</table>
															</h5>
														</div>
														@endforeach
														</div>
													</div>
													<a href="javascript:void()" class="btn btn-primary btn-lg btn-block" onclick="add_categorie()">Cliquez pour Ajouter une Categorie</a>
													<form action="{{ route('form_add_categorie') }}" method="GET" enctype="multipart/form-data" class="form-horizontal" role="form" id="form_add_categorie" style="display: none;">
														{{ csrf_field() }}
														<div class="form-group">
															<label class="col-md-10 control-label">Ajouter une Categorie ici</label>
															<input type="text" class="form-input input form-control" name="add_categorie" id="add_categorie"/>
														</div>
														<div class="col-md-10 col-md-offset-4">
															<button type="submit" class="btn btn-success">
																<i class="fa fa-btn fa-sign-in"></i>Ajouter
															</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			@include('footer')
		</div>
		
        <!-- Custom template | don't include it in your project! -->
        @include('rightbar')
		
		<!-- End Custom template -->
	</div>
	<!--   Core JS Files   -->
	@include('script')


<script>
    function add_family() {
        document.getElementById("form_add_family").style.display="block";
    }
    function add_type() {
        document.getElementById("form_add_type").style.display="block";
    }
    function add_categorie() {
        document.getElementById("form_add_categorie").style.display="block";
    }
</script>

@php
	$product = DB::select('select id from product ');$product = count($product);
	$user = DB::select('select id from users ');$user = count($user);
@endphp
<script>
    Circles.create({
        id:'circles-1',
        radius:45,
        value:60,
        maxValue:100,
        width:7,
        text: {{ $product }},
        colors:['#f1f1f1', '#FF9E27'],
        duration:400,
        wrpClass:'circles-wrp',
        textClass:'circles-text',
        styleWrapper:true,
        styleText:true
    })

    Circles.create({
        id:'circles-2',
        radius:45,
        value:70,
        maxValue:100,
        width:7,
        text: {{ $product }},
        colors:['#f1f1f1', '#2BB930'],
        duration:400,
        wrpClass:'circles-wrp',
        textClass:'circles-text',
        styleWrapper:true,
        styleText:true
    })

    Circles.create({
        id:'circles-3',
        radius:45,
        value:40,
        maxValue:100,
        width:7,
        text: {{ $user }},
        colors:['#f1f1f1', '#F25961'],
        duration:400,
        wrpClass:'circles-wrp',
        textClass:'circles-text',
        styleWrapper:true,
        styleText:true
    })


    $('#lineChart').sparkline([105,103,123,100,95,105,115], {
        type: 'line',
        height: '70',
        width: '100%',
        lineWidth: '2',
        lineColor: '#ffa534',
        fillColor: 'rgba(255, 165, 52, .14)'
    });
</script>
</body>
</html>