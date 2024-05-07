@extends('index')
@push('title', get_phrase('Organization Chart'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

<div class="mainSection-title">
	<div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
		<div class="d-flex flex-column">
			<ul class="d-flex align-items-center eBreadcrumb-2">
				<li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
				<li><a href="#">{{ get_phrase('Organisation Chart') }}</a></li>
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
		background: #e6eaf5 !important;
	}

	.node img {
		border-radius: 85px;
		width: 50px;
		height: 50px;
		margin-bottom: 15px;
		margin-top: 15px;

	}

	h2:hover {
		background: #c0c0c052 !important;
		cursor: text;
	}

	.designation {
		font-size: 12px !important;
		line-height: 18px;
		word-spacing: 1px;
		font-weight: 500;
	}

	#orgChart {
		overflow: scroll;
	}

	h2 {
		line-height: 14px;
		font-size: 12px !important;

	}

	body {
		color: #0395ab;
	}

	.apextree-node{
		/* height: 150px !important; */
    	text-align: center;
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

	$(document).ready(function() {
		$(document).ready(function() {
			var testData = <?php echo json_encode($all_users_structure); ?>;
			console.log(testData);
			const data = {
				id: 'ms',
				data: {
					imageURL: 'https://i.pravatar.cc/300?img=68',
					name: 'Margret Swanson',
				},
				options: {
					nodeBGColor: '#cdb4db',
					nodeBGColorHover: '#cdb4db',
				},
				children: [{
						id: 'mh',
						data: {
							imageURL: 'https://i.pravatar.cc/300?img=69',
							name: 'Mark Hudson',
						},
						options: {
							nodeBGColor: '#ffafcc',
							nodeBGColorHover: '#ffafcc',
						},
						children: [{
								id: 'kb',
								data: {
									imageURL: 'https://i.pravatar.cc/300?img=65',
									name: 'Karyn Borbas',
								},
								options: {
									nodeBGColor: '#f8ad9d',
									nodeBGColorHover: '#f8ad9d',
								},
							},
							{
								id: 'cr',
								data: {
									imageURL: 'https://i.pravatar.cc/300?img=60',
									name: 'Chris Rup',
								},
								options: {
									nodeBGColor: '#c9cba3',
									nodeBGColorHover: '#c9cba3',
								},
							},
						],
					},
					{
						id: 'cs',
						data: {
							imageURL: 'https://i.pravatar.cc/300?img=59',
							name: 'Chris Lysek',
						},
						options: {
							nodeBGColor: '#00afb9',
							nodeBGColorHover: '#00afb9',
						},
						children: [{
								id: 'Noah_Chandler',
								data: {
									imageURL: 'https://i.pravatar.cc/300?img=57',
									name: 'Noah Chandler',
								},
								options: {
									nodeBGColor: '#84a59d',
									nodeBGColorHover: '#84a59d',
								},
							},
							{
								id: 'Felix_Wagner',
								data: {
									imageURL: 'https://i.pravatar.cc/300?img=52',
									name: 'Felix Wagner',
								},
								options: {
									nodeBGColor: '#0081a7',
									nodeBGColorHover: '#0081a7',
								},
							},
						],
					},
				],
			};
			const options = {
				contentKey: 'data',
				width: 1000,
				height: 600,
				nodeWidth: 170,
				nodeHeight: 150,
				fontColor: '#fff',
				borderColor: '#333',
				childrenSpacing: 100,
				siblingSpacing: 60,
				direction: 'top',
				zoom:10,
				enableExpandCollapse: true,
				nodeTemplate: (content) =>
					`<div style='display: flex;flex-direction: column;gap: 10px;justify-content: center;align-items: center;height: 100%;'>
				<img style='width: 50px;height: 50px;border-radius: 50%;' src='${content.imageURL}' alt='' />
				<div style="font-weight: bold; font-family: Arial; font-size: 14px">${content.name}</div>
				</div>`,
				canvasStyle: 'border: 1px solid black;background: #f6f6f6;',
				enableToolbar: true,
			};
			const tree = new ApexTree(document.getElementById('orgChart'), options);
			tree.render(testData);
		})
	})

	setTimeout(()=>{
		document.getElementById("zoom-in").click();
		document.getElementById("zoom-in").click();
		document.getElementById("zoom-in").click();
		document.getElementById("zoom-in").click();
		document.getElementById("zoom-in").click();
		document.getElementById("zoom-in").click();
	}, 2000)

	
</script>
@endpush