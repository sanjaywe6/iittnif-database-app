<?php
	require(__DIR__ . '/incCommon.php');

	$GLOBALS['page_title'] = $Translation['app documentation'];
	include(__DIR__ . '/incHeader.php');
?>
<div class="page-header"><h1><?php echo APP_TITLE . ' ' . $Translation['app documentation']; ?></h1></div>
<div class="row">
	<div class="col-md-3 col-lg-2" id="toc-section">
		<nav class="hidden-print hidden-xs hidden-sm affix">
			<ul class="nav">
				<li>
					<a href="#content-section"><?php echo APP_TITLE; ?></a>
					<ul class="nav">
						<li>
							<a href="#table-event_decision_table">Decision - App</a>
							<ul class="nav">
								<li><a href="#field-event_decision_table-decision_id">ID</a></li>
								<li><a href="#field-event_decision_table-decision_status">Decision status</a></li>
								<li><a href="#field-event_decision_table-decision_status_remarks_by_superior">Decision status remarks by superior</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-meetings_table">Meetings - App</a>
							<ul class="nav">
								<li><a href="#field-meetings_table-meetings_id">ID</a></li>
								<li><a href="#field-meetings_table-meeting_title">Meeting title</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-agenda_table">Agenda - App</a>
							<ul class="nav">
								<li><a href="#field-agenda_table-agenda_id">ID</a></li>
								<li><a href="#field-agenda_table-meeting_lookup">Meeting</a></li>
								<li><a href="#field-agenda_table-agenda_description">Agenda description</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-decision_table">Decision - App</a>
							<ul class="nav">
								<li><a href="#field-decision_table-decision_id">ID</a></li>
								<li><a href="#field-decision_table-decision_status">Decision status</a></li>
								<li><a href="#field-decision_table-decision_status_remarks_by_superior">Decision status remarks by superior</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-mou_details_table">MoU details - App</a>
							<ul class="nav">
								<li><a href="#field-mou_details_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-mou_company_area_details_table">MoU company area details - App</a>
							<ul class="nav">
								<li><a href="#field-mou_company_area_details_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-goal_progress_table">Goal progress table</a>
							<ul class="nav">
								<li><a href="#field-goal_progress_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-internship_fellowship_details_app">Internship/Fellowship details - App</a>
							<ul class="nav">
								<li><a href="#field-internship_fellowship_details_app-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-star_pnt">Star-PNT - APP</a>
							<ul class="nav">
								<li><a href="#field-star_pnt-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-hrd_sdp_events_table">HRD & SDP Events - App</a>
							<ul class="nav">
								<li><a href="#field-hrd_sdp_events_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-training_program_on_geospatial_tchnologies_table">Training Program on Geospatial Technologies Details - App</a>
							<ul class="nav">
								<li><a href="#field-training_program_on_geospatial_tchnologies_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-space_day_school_details_app">Space day school student details app</a>
							<ul class="nav">
								<li><a href="#field-space_day_school_details_app-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-space_day_college_student_table">Space day college student - App</a>
							<ul class="nav">
								<li><a href="#field-space_day_college_student_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-school_list">School List - App</a>
							<ul class="nav">
								<li><a href="#field-school_list-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-sdp_participants_college_details_table">SDP participants college details - App</a>
							<ul class="nav">
								<li><a href="#field-sdp_participants_college_details_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-personal_data_table">Employee personal data - App</a>
							<ul class="nav">
								<li><a href="#field-personal_data_table-personal_data_id">ID</a></li>
								<li><a href="#field-personal_data_table-name">Name</a></li>
								<li><a href="#field-personal_data_table-designation">Designation</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-employees_designation_table">Employees designation table</a>
							<ul class="nav">
								<li><a href="#field-employees_designation_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-attendence_details_table">Attendence details - App</a>
							<ul class="nav">
								<li><a href="#field-attendence_details_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-all_startup_data_table">All Startups Data - App</a>
							<ul class="nav">
								<li><a href="#field-all_startup_data_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-shortlisted_startups_dd_and_agreement_table">Shortlisted startups DD and Agreement - App</a>
							<ul class="nav">
								<li><a href="#field-shortlisted_startups_dd_and_agreement_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-vikas_startup_applications_table">Vikas startup applications - App</a>
							<ul class="nav">
								<li><a href="#field-vikas_startup_applications_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-approval_table">Approval - App</a>
							<ul class="nav">
								<li><a href="#field-approval_table-procurement_approval_id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-payment_track_details_table">Payment track details - App</a>
							<ul class="nav">
								<li><a href="#field-payment_track_details_table-payment_track_details_id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-car_table">Car - App</a>
							<ul class="nav">
								<li><a href="#field-car_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-car_usage_table">Car usage table</a>
							<ul class="nav">
								<li><a href="#field-car_usage_table-car_usage_id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-travel_table">Travel - App</a>
							<ul class="nav">
								<li><a href="#field-travel_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-travel_cab_table">Travel cab details - App</a>
							<ul class="nav">
								<li><a href="#field-travel_cab_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-travel_flight_table">Travel flight table</a>
							<ul class="nav">
								<li><a href="#field-travel_flight_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-travel_hotel_table">Travel hotel details - App</a>
							<ul class="nav">
								<li><a href="#field-travel_hotel_table-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-operation_dronagiri_data_submission_app">Operation dronagiri data submission - App</a>
							<ul class="nav">
								<li><a href="#field-operation_dronagiri_data_submission_app-data_id">ID</a></li>
								<li><a href="#field-operation_dronagiri_data_submission_app-name_of_the_department">Name of the department</a></li>
								<li><a href="#field-operation_dronagiri_data_submission_app-name_of_the_officer">Name of the officer</a></li>
								<li><a href="#field-operation_dronagiri_data_submission_app-designation">Designation</a></li>
								<li><a href="#field-operation_dronagiri_data_submission_app-email_address">Email address</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-file_table">File table</a>
							<ul class="nav">
								<li><a href="#field-file_table-file_id">ID</a></li>
								<li><a href="#field-file_table-data_str_key">Data str key</a></li>
								<li><a href="#field-file_table-name_title_of_the_dataset">Name/Title of the dataset</a></li>
								<li><a href="#field-file_table-category_of_the_dataset">Category of the dataset</a></li>
								<li><a href="#field-file_table-description_of_the_dataset">Description of the dataset (Provide a brief note on the dataset content, including what the data represents.)</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-panel_decision_table_tdp">Panel Decision App</a>
							<ul class="nav">
								<li><a href="#field-panel_decision_table_tdp-panel_decision_id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-selected_proposals_final_tdp">Selected proposals final - App</a>
							<ul class="nav">
								<li><a href="#field-selected_proposals_final_tdp-selected_proposals_id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-stage_wise_budget_table_tdp">Stage wise budget - App</a>
							<ul class="nav">
								<li><a href="#field-stage_wise_budget_table_tdp-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-first_level_shortlisted_proposals_tdp">First level shortlisted proposals - App</a>
							<ul class="nav">
								<li><a href="#field-first_level_shortlisted_proposals_tdp-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-budget_table_tdp">Budget App</a>
							<ul class="nav">
								<li><a href="#field-budget_table_tdp-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-panel_comments_tdp">Panel comments - App</a>
							<ul class="nav">
								<li><a href="#field-panel_comments_tdp-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-selected_tdp">Selected (Draft) - App</a>
							<ul class="nav">
								<li><a href="#field-selected_tdp-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-address_tdp">Address Details - App</a>
							<ul class="nav">
								<li><a href="#field-address_tdp-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-summary_table_tdp">Summary - App</a>
							<ul class="nav">
								<li><a href="#field-summary_table_tdp-id">ID</a></li>
							</ul>
						</li>
						<li>
							<a href="#table-project_details_tdp">Project details - App</a>
							<ul class="nav">
								<li><a href="#field-project_details_tdp-id">ID</a></li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
			<a class="back-to-top" href="#content-section"><?php echo $Translation['back to top']; ?></a>
		</nav>
	</div>

	<div class="col-md-9 col-lg-8" id="content-section">
		<p class="app-documentation" id="app-title">



		</p>

		<h2 class="table-documentation" id="table-event_decision_table">Decision - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-event_decision_table-decision_id">ID</h3>
		<p class="field-documentation">

agenda_decision_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h3 class="field-documentation" id="field-event_decision_table-decision_status">Decision status</h3>
		<p class="field-documentation">

agenda_decision_status varchar(250) YES   

		</p>
		<h3 class="field-documentation" id="field-event_decision_table-decision_status_remarks_by_superior">Decision status remarks by superior</h3>
		<p class="field-documentation">

agenda_status_remarks_by_superior varchar(250) YES   

		</p>
		<h2 class="table-documentation" id="table-meetings_table">Meetings - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-meetings_table-meetings_id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h3 class="field-documentation" id="field-meetings_table-meeting_title">Meeting title</h3>
		<p class="field-documentation">

meeting_title varchar(250) YES   

		</p>
		<h2 class="table-documentation" id="table-agenda_table">Agenda - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-agenda_table-agenda_id">ID</h3>
		<p class="field-documentation">

agenda_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h3 class="field-documentation" id="field-agenda_table-meeting_lookup">Meeting</h3>
		<p class="field-documentation">

meeting_title_key int(10) unsigned YES MUL  

		</p>
		<h3 class="field-documentation" id="field-agenda_table-agenda_description">Agenda description</h3>
		<p class="field-documentation">

agenda varchar(250) YES   

		</p>
		<h2 class="table-documentation" id="table-decision_table">Decision - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-decision_table-decision_id">ID</h3>
		<p class="field-documentation">

agenda_decision_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h3 class="field-documentation" id="field-decision_table-decision_status">Decision status</h3>
		<p class="field-documentation">

agenda_decision_status varchar(250) YES   

		</p>
		<h3 class="field-documentation" id="field-decision_table-decision_status_remarks_by_superior">Decision status remarks by superior</h3>
		<p class="field-documentation">

agenda_status_remarks_by_superior varchar(250) YES   

		</p>
		<h2 class="table-documentation" id="table-mou_details_table">MoU details - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-mou_details_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-mou_company_area_details_table">MoU company area details - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-mou_company_area_details_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-goal_progress_table">Goal progress table</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-goal_progress_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-internship_fellowship_details_app">Internship/Fellowship details - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-internship_fellowship_details_app-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-star_pnt">Star-PNT - APP</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-star_pnt-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-hrd_sdp_events_table">HRD & SDP Events - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-hrd_sdp_events_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-training_program_on_geospatial_tchnologies_table">Training Program on Geospatial Technologies Details - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-training_program_on_geospatial_tchnologies_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-space_day_school_details_app">Space day school student details app</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-space_day_school_details_app-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-space_day_college_student_table">Space day college student - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-space_day_college_student_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-school_list">School List - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-school_list-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-sdp_participants_college_details_table">SDP participants college details - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-sdp_participants_college_details_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-personal_data_table">Employee personal data - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-personal_data_table-personal_data_id">ID</h3>
		<p class="field-documentation">

tour_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h3 class="field-documentation" id="field-personal_data_table-name">Name</h3>
		<p class="field-documentation">

tour_place varchar(250) YES   

		</p>
		<h3 class="field-documentation" id="field-personal_data_table-designation">Designation</h3>
		<p class="field-documentation">

tour_description text YES   

		</p>
		<h2 class="table-documentation" id="table-employees_designation_table">Employees designation table</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-employees_designation_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-attendence_details_table">Attendence details - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-attendence_details_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-all_startup_data_table">All Startups Data - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-all_startup_data_table-id">ID</h3>
		<p class="field-documentation">

tour_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-shortlisted_startups_dd_and_agreement_table">Shortlisted startups DD and Agreement - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-shortlisted_startups_dd_and_agreement_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-vikas_startup_applications_table">Vikas startup applications - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-vikas_startup_applications_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-approval_table">Approval - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-approval_table-procurement_approval_id">ID</h3>
		<p class="field-documentation">

tour_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-payment_track_details_table">Payment track details - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-payment_track_details_table-payment_track_details_id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-car_table">Car - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-car_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-car_usage_table">Car usage table</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-car_usage_table-car_usage_id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-travel_table">Travel - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-travel_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-travel_cab_table">Travel cab details - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-travel_cab_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-travel_flight_table">Travel flight table</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-travel_flight_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-travel_hotel_table">Travel hotel details - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-travel_hotel_table-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-operation_dronagiri_data_submission_app">Operation dronagiri data submission - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-operation_dronagiri_data_submission_app-data_id">ID</h3>
		<p class="field-documentation">

tour_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h3 class="field-documentation" id="field-operation_dronagiri_data_submission_app-name_of_the_department">Name of the department</h3>
		<p class="field-documentation">

tour_description text YES   

		</p>
		<h3 class="field-documentation" id="field-operation_dronagiri_data_submission_app-name_of_the_officer">Name of the officer</h3>
		<p class="field-documentation">

tour_place varchar(250) YES   

		</p>
		<h3 class="field-documentation" id="field-operation_dronagiri_data_submission_app-designation">Designation</h3>
		<p class="field-documentation">

tour_to_date date YES   

		</p>
		<h3 class="field-documentation" id="field-operation_dronagiri_data_submission_app-email_address">Email address</h3>
		<p class="field-documentation">

tour_participants varchar(250) YES   

		</p>
		<h2 class="table-documentation" id="table-file_table">File table</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-file_table-file_id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h3 class="field-documentation" id="field-file_table-data_str_key">Data str key</h3>
		<p class="field-documentation">

tour_description_key int(10) unsigned YES MUL  

		</p>
		<h3 class="field-documentation" id="field-file_table-name_title_of_the_dataset">Name/Title of the dataset</h3>
		<p class="field-documentation">

meeting_title varchar(250) YES   

		</p>
		<h3 class="field-documentation" id="field-file_table-category_of_the_dataset">Category of the dataset</h3>
		<p class="field-documentation">

meeting_date date YES   

		</p>
		<h3 class="field-documentation" id="field-file_table-description_of_the_dataset">Description of the dataset (Provide a brief note on the dataset content, including what the data represents.)</h3>
		<p class="field-documentation">

meeting_attendees_list varchar(250) YES   

		</p>
		<h2 class="table-documentation" id="table-panel_decision_table_tdp">Panel Decision App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-panel_decision_table_tdp-panel_decision_id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-selected_proposals_final_tdp">Selected proposals final - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-selected_proposals_final_tdp-selected_proposals_id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-stage_wise_budget_table_tdp">Stage wise budget - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-stage_wise_budget_table_tdp-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-first_level_shortlisted_proposals_tdp">First level shortlisted proposals - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-first_level_shortlisted_proposals_tdp-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-budget_table_tdp">Budget App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-budget_table_tdp-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-panel_comments_tdp">Panel comments - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-panel_comments_tdp-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-selected_tdp">Selected (Draft) - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-selected_tdp-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-address_tdp">Address Details - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-address_tdp-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-summary_table_tdp">Summary - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-summary_table_tdp-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
		<h2 class="table-documentation" id="table-project_details_tdp">Project details - App</h2>
		<p class="table-documentation">



		</p>

		<h3 class="field-documentation" id="field-project_details_tdp-id">ID</h3>
		<p class="field-documentation">

meetings_id int(10) unsigned NO PRI  auto_increment

		</p>
	</div>
</div>

<style>
	body { position: relative; }
	#toc-section ul.nav:nth-child(2) {
		margin-left: 1.5em;
	}
	#content-section { border-left: 1px dotted #ddd; padding-top: 6em; }
	h2.table-documentation, h3.field-documentation { padding-top: 3em; }
	#toc-section li.active { font-weight: bold; }
	#toc-section li:not(.active) { font-weight: normal; }
</style>

<script>
	$j(function() {
		$j('body').scrollspy({ target: '#toc-section', offset: 80 });
	})
</script>

<?php
	include(__DIR__ . '/incFooter.php');
