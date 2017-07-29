<div class="page-content">
	<div class="page-header">
		<h1>
			Tables
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				Static &amp; Dynamic Tables
			</small>
		</h1>
	</div><!-- /.page-header -->

	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<!-- top naviagtion -->
					<div class="row" style="margin-bottom: 10px;">
					    <div class="col-xs-6">
					        <div class="dataTables_length" id="dynamic-table_length">
					        	<label style="float:left;margin-right:5px;">Display</label> 
					        	<select name="dynamic-table_length" aria-controls="dynamic-table" class="form-control input-sm">
					        		<option value="10">10</option>
					        		<option value="25">25</option>
					        		<option value="50">50</option>
					        		<option value="100">100</option>
					        	</select> 
					        </div>
					    </div>
					    <div class="col-xs-6">
					        <div id="dynamic-table_filter" class="dataTables_filter">
					        	<label style="margin-right:5px;">Search</label>
					        	<input type="search" class="form-control input-sm" placeholder="" aria-controls="dynamic-table" style="float:right">
					        </div>
					    </div>
					</div>
					<!-- End top navigation -->
					<table class="table table-striped table-bordered table-hover" id="simple-table">
						<thead>
							<tr>
								<th class="center">
									<label class="pos-rel">
										<input type="checkbox" class="ace">
										<span class="lbl"></span>
									</label>
								</th>
								<th>Domain</th>
								<th>Price</th>
								<th class="hidden-480">Clicks</th>

								<th>
									<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
									Update
								</th>
								<th class="hidden-480">Status</th>

								<th></th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td class="center">
									<label class="pos-rel">
										<input type="checkbox" class="ace">
										<span class="lbl"></span>
									</label>
								</td>

								<td>
									<a href="#">ace.com</a>
								</td>
								<td>$45</td>
								<td class="hidden-480">3,330</td>
								<td>Feb 12</td>

								<td class="hidden-480">
									<span class="label label-sm label-warning">Expiring</span>
								</td>

								<td>
									<div class="hidden-sm hidden-xs btn-group">
										<button class="btn btn-xs btn-success">
											<i class="ace-icon fa fa-check bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-info">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-danger">
											<i class="ace-icon fa fa-trash-o bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-warning">
											<i class="ace-icon fa fa-flag bigger-120"></i>
										</button>
									</div>

									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
											<button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle">
												<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
												<li>
													<a title="" data-rel="tooltip" class="tooltip-info" href="#" data-original-title="View">
														<span class="blue">
															<i class="ace-icon fa fa-search-plus bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a title="" data-rel="tooltip" class="tooltip-success" href="#" data-original-title="Edit">
														<span class="green">
															<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a title="" data-rel="tooltip" class="tooltip-error" href="#" data-original-title="Delete">
														<span class="red">
															<i class="ace-icon fa fa-trash-o bigger-120"></i>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</td>
							</tr>

							<tr>
								<td class="center">
									<label class="pos-rel">
										<input type="checkbox" class="ace">
										<span class="lbl"></span>
									</label>
								</td>

								<td>
									<a href="#">base.com</a>
								</td>
								<td>$35</td>
								<td class="hidden-480">2,595</td>
								<td>Feb 18</td>

								<td class="hidden-480">
									<span class="label label-sm label-success">Registered</span>
								</td>

								<td>
									<div class="hidden-sm hidden-xs btn-group">
										<button class="btn btn-xs btn-success">
											<i class="ace-icon fa fa-check bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-info">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-danger">
											<i class="ace-icon fa fa-trash-o bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-warning">
											<i class="ace-icon fa fa-flag bigger-120"></i>
										</button>
									</div>

									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
											<button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle">
												<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
												<li>
													<a title="" data-rel="tooltip" class="tooltip-info" href="#" data-original-title="View">
														<span class="blue">
															<i class="ace-icon fa fa-search-plus bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a title="" data-rel="tooltip" class="tooltip-success" href="#" data-original-title="Edit">
														<span class="green">
															<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a title="" data-rel="tooltip" class="tooltip-error" href="#" data-original-title="Delete">
														<span class="red">
															<i class="ace-icon fa fa-trash-o bigger-120"></i>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</td>
							</tr>

							<tr>
								<td class="center">
									<label class="pos-rel">
										<input type="checkbox" class="ace">
										<span class="lbl"></span>
									</label>
								</td>

								<td>
									<a href="#">max.com</a>
								</td>
								<td>$60</td>
								<td class="hidden-480">4,400</td>
								<td>Mar 11</td>

								<td class="hidden-480">
									<span class="label label-sm label-warning">Expiring</span>
								</td>

								<td>
									<div class="hidden-sm hidden-xs btn-group">
										<button class="btn btn-xs btn-success">
											<i class="ace-icon fa fa-check bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-info">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-danger">
											<i class="ace-icon fa fa-trash-o bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-warning">
											<i class="ace-icon fa fa-flag bigger-120"></i>
										</button>
									</div>

									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
											<button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle">
												<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
												<li>
													<a title="" data-rel="tooltip" class="tooltip-info" href="#" data-original-title="View">
														<span class="blue">
															<i class="ace-icon fa fa-search-plus bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a title="" data-rel="tooltip" class="tooltip-success" href="#" data-original-title="Edit">
														<span class="green">
															<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a title="" data-rel="tooltip" class="tooltip-error" href="#" data-original-title="Delete">
														<span class="red">
															<i class="ace-icon fa fa-trash-o bigger-120"></i>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</td>
							</tr>

							<tr>
								<td class="center">
									<label class="pos-rel">
										<input type="checkbox" class="ace">
										<span class="lbl"></span>
									</label>
								</td>

								<td>
									<a href="#">best.com</a>
								</td>
								<td>$75</td>
								<td class="hidden-480">6,500</td>
								<td>Apr 03</td>

								<td class="hidden-480">
									<span class="label label-sm label-inverse arrowed-in">Flagged</span>
								</td>

								<td>
									<div class="hidden-sm hidden-xs btn-group">
										<button class="btn btn-xs btn-success">
											<i class="ace-icon fa fa-check bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-info">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-danger">
											<i class="ace-icon fa fa-trash-o bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-warning">
											<i class="ace-icon fa fa-flag bigger-120"></i>
										</button>
									</div>

									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
											<button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle">
												<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
												<li>
													<a title="" data-rel="tooltip" class="tooltip-info" href="#" data-original-title="View">
														<span class="blue">
															<i class="ace-icon fa fa-search-plus bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a title="" data-rel="tooltip" class="tooltip-success" href="#" data-original-title="Edit">
														<span class="green">
															<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a title="" data-rel="tooltip" class="tooltip-error" href="#" data-original-title="Delete">
														<span class="red">
															<i class="ace-icon fa fa-trash-o bigger-120"></i>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</td>
							</tr>

							<tr>
								<td class="center">
									<label class="pos-rel">
										<input type="checkbox" class="ace">
										<span class="lbl"></span>
									</label>
								</td>

								<td>
									<a href="#">pro.com</a>
								</td>
								<td>$55</td>
								<td class="hidden-480">4,250</td>
								<td>Jan 21</td>

								<td class="hidden-480">
									<span class="label label-sm label-success">Registered</span>
								</td>

								<td>
									<div class="hidden-sm hidden-xs btn-group">
										<button class="btn btn-xs btn-success">
											<i class="ace-icon fa fa-check bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-info">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-danger">
											<i class="ace-icon fa fa-trash-o bigger-120"></i>
										</button>

										<button class="btn btn-xs btn-warning">
											<i class="ace-icon fa fa-flag bigger-120"></i>
										</button>
									</div>

									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
											<button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle">
												<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
												<li>
													<a title="" data-rel="tooltip" class="tooltip-info" href="#" data-original-title="View">
														<span class="blue">
															<i class="ace-icon fa fa-search-plus bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a title="" data-rel="tooltip" class="tooltip-success" href="#" data-original-title="Edit">
														<span class="green">
															<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
														</span>
													</a>
												</li>

												<li>
													<a title="" data-rel="tooltip" class="tooltip-error" href="#" data-original-title="Delete">
														<span class="red">
															<i class="ace-icon fa fa-trash-o bigger-120"></i>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<!-- page navigation -->
					<div class="row">
					    <div class="col-sm-6 col-xs-12 hidden-xs">
					        <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">Showing 1 to 10 of 23 entries</div>
					    </div>
					    <div class="col-sm-6 col-xs-12">
					        <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
					            <ul class="pagination list-unstyled" style="margin:0">
					                <li class="paginate_button previous disabled" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous"><a href="#">Previous</a></li>
					                <li class="paginate_button active" aria-controls="dynamic-table" tabindex="0"><a href="#">1</a></li>
					                <li class="paginate_button " aria-controls="dynamic-table" tabindex="0"><a href="#">2</a></li>
					                <li class="paginate_button " aria-controls="dynamic-table" tabindex="0"><a href="#">3</a></li>
					                <li class="paginate_button next" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next"><a href="#">Next</a></li>
					            </ul>
					        </div>
					    </div>
					</div>
					<!-- End gape navigate -->
				</div><!-- /.span -->
			</div><!-- /.row -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

<?=$this->registerJs("
jQuery(function($) {
	var active_class = 'active';
	$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
		var th_checked = this.checked;
		
		$(this).closest('table').find('tbody > tr').each(function(){
			var row = this;
			if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
			else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
		});
	});
})
");?>