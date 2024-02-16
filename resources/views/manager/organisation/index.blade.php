@extends('index')
@push('title', get_phrase('Organization'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

<div class="mainSection-title">
	<div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
		<div class="d-flex flex-column">
			<ul class="d-flex align-items-center eBreadcrumb-2">
				<li><a href="{{ route('manager.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
				<li><a href="#">{{ get_phrase('Organisation') }}</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="eSection-wrap">
			<div class="row">
				<div class="content">
					<div id="orgChart"></div>

				</div>
			</div>
		</div>
	</div>

</div>
<style>

	.node {
		height: 160px !important;
		width: 160px !important;
		background:#e6eaf5 !important;
	}
	.node img{
		border-radius: 85px;
		width: 50px;
		height: 50px;
		margin-bottom:15px;
		margin-top:15px;
		
	} 
	h2:hover {
    background:#c0c0c052 !important;
    cursor: text;
}
    .designation{
		font-size:12px !important;
		line-height:18px;
		word-spacing:1px;
		font-weight:500;
	}
	#orgChart{
		overflow: scroll;
	}
	h2{
		line-height:14px;
		font-size:12px !important;

	}
	body{
		color:#0395ab;
	}


</style>
@endsection

@push('js')
<script>
	"use strict";
	function generateChart(users) {
		let root_users = [];
		for (let i = 0; i < users.length; i++) {
			if (users) {
				if (users[i]['id'] == users[i]['manager']) {
					root_users.push(users[i]);
				}
			}
		}
		if (root_users) {
			generateDOM();
			let sub_users = getSubUsers();
		}
	}

	function generateDOM() {

	}

	function getSubUsers(manager_id) {
		let sub_users = [];
		for (let i = 0; i < users.length; i++) {
			if (users) {
				if (users[i]['manager'] == manager_id) {
					sub_users.push(users[i]);
				}
			}
		}
		return sub_users;
	}

	$(document).ready(function(){
		$(document).ready(function(){
		var testData = <?php echo json_encode($all_users_structure); ?>;
		var testData1 = [
			{id: 1, name: '<img src="/hr/public/uploads/user-image/wRb1AWZzrh9pU286HDcq.jpg" height="42px"> </br> My Organization', parent: 0},
			{id: 2, name: 'CEO Office', parent: 1},
			{id: 3, name: 'Division 1', parent: 1},
			{id: 4, name: 'Division 2', parent: 1},
			{id: 6, name: 'Division 3', parent: 1},
			{id: 7, name: 'Division 4', parent: 1},
			{id: 8, name: 'Division 5', parent: 1},
			{id: 5, name: 'Sub Division', parent: 3},
		];
		console.log(testData);
		console.log(testData1);
		org_chart = $('#orgChart').orgChart({
			data: testData, // your data
			showControls: false, // display add or remove node button.
			allowEdit: false, // click the node's title to edit
			onAddNode: function(node){},
			onDeleteNode: function(node){},
			onClickNode: function(node){},
			newNodeText: 'Add Child' // text of add button
		});
	})
	})
</script>
@endpush