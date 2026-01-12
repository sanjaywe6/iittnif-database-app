var FiltersEnabled = 0; // if your not going to use transitions or filters in any of the tips set this to 0
var spacer="&nbsp; &nbsp; &nbsp; ";

// email notifications to admin
notifyAdminNewMembers0Tip=["", spacer+"No email notifications to admin."];
notifyAdminNewMembers1Tip=["", spacer+"Notify admin only when a new member is waiting for approval."];
notifyAdminNewMembers2Tip=["", spacer+"Notify admin for all new sign-ups."];

// visitorSignup
visitorSignup0Tip=["", spacer+"If this option is selected, visitors will not be able to join this group unless the admin manually moves them to this group from the admin area."];
visitorSignup1Tip=["", spacer+"If this option is selected, visitors can join this group but will not be able to sign in unless the admin approves them from the admin area."];
visitorSignup2Tip=["", spacer+"If this option is selected, visitors can join this group and will be able to sign in instantly with no need for admin approval."];

// user_table table
user_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'User Table' table. A member who adds a record to the table becomes the 'owner' of that record."];

user_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'User Table' table."];
user_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'User Table' table."];
user_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'User Table' table."];
user_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'User Table' table."];

user_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'User Table' table."];
user_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'User Table' table."];
user_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'User Table' table."];
user_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'User Table' table, regardless of their owner."];

user_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'User Table' table."];
user_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'User Table' table."];
user_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'User Table' table."];
user_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'User Table' table."];

// suggestion table
suggestion_addTip=["",spacer+"This option allows all members of the group to add records to the 'Suggestion/Complaint - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

suggestion_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Suggestion/Complaint - App' table."];
suggestion_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Suggestion/Complaint - App' table."];
suggestion_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Suggestion/Complaint - App' table."];
suggestion_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Suggestion/Complaint - App' table."];

suggestion_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Suggestion/Complaint - App' table."];
suggestion_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Suggestion/Complaint - App' table."];
suggestion_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Suggestion/Complaint - App' table."];
suggestion_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Suggestion/Complaint - App' table, regardless of their owner."];

suggestion_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Suggestion/Complaint - App' table."];
suggestion_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Suggestion/Complaint - App' table."];
suggestion_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Suggestion/Complaint - App' table."];
suggestion_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Suggestion/Complaint - App' table."];

// approval_table table
approval_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Approval - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

approval_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Approval - App' table."];
approval_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Approval - App' table."];
approval_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Approval - App' table."];
approval_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Approval - App' table."];

approval_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Approval - App' table."];
approval_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Approval - App' table."];
approval_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Approval - App' table."];
approval_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Approval - App' table, regardless of their owner."];

approval_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Approval - App' table."];
approval_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Approval - App' table."];
approval_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Approval - App' table."];
approval_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Approval - App' table."];

// techlead_web_page table
techlead_web_page_addTip=["",spacer+"This option allows all members of the group to add records to the 'Tech Manager Web Page  - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

techlead_web_page_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Tech Manager Web Page  - App' table."];
techlead_web_page_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Tech Manager Web Page  - App' table."];
techlead_web_page_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Tech Manager Web Page  - App' table."];
techlead_web_page_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Tech Manager Web Page  - App' table."];

techlead_web_page_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Tech Manager Web Page  - App' table."];
techlead_web_page_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Tech Manager Web Page  - App' table."];
techlead_web_page_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Tech Manager Web Page  - App' table."];
techlead_web_page_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Tech Manager Web Page  - App' table, regardless of their owner."];

techlead_web_page_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Tech Manager Web Page  - App' table."];
techlead_web_page_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Tech Manager Web Page  - App' table."];
techlead_web_page_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Tech Manager Web Page  - App' table."];
techlead_web_page_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Tech Manager Web Page  - App' table."];

// navavishkar_stay_facilities_table table
navavishkar_stay_facilities_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Navavishkar Stay Facilities - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

navavishkar_stay_facilities_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Navavishkar Stay Facilities - App' table."];

navavishkar_stay_facilities_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Navavishkar Stay Facilities - App' table, regardless of their owner."];

navavishkar_stay_facilities_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Navavishkar Stay Facilities - App' table."];

// navavishkar_stay_facilities_allotment_table table
navavishkar_stay_facilities_allotment_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Navavishkar Stay Facilities - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

navavishkar_stay_facilities_allotment_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_allotment_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_allotment_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_allotment_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Navavishkar Stay Facilities - App' table."];

navavishkar_stay_facilities_allotment_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_allotment_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_allotment_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_allotment_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Navavishkar Stay Facilities - App' table, regardless of their owner."];

navavishkar_stay_facilities_allotment_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_allotment_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_allotment_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Navavishkar Stay Facilities - App' table."];
navavishkar_stay_facilities_allotment_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Navavishkar Stay Facilities - App' table."];

// car_table table
car_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Car - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

car_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Car - App' table."];
car_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Car - App' table."];
car_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Car - App' table."];
car_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Car - App' table."];

car_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Car - App' table."];
car_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Car - App' table."];
car_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Car - App' table."];
car_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Car - App' table, regardless of their owner."];

car_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Car - App' table."];
car_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Car - App' table."];
car_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Car - App' table."];
car_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Car - App' table."];

// car_usage_table table
car_usage_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Car usage table' table. A member who adds a record to the table becomes the 'owner' of that record."];

car_usage_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Car usage table' table."];
car_usage_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Car usage table' table."];
car_usage_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Car usage table' table."];
car_usage_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Car usage table' table."];

car_usage_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Car usage table' table."];
car_usage_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Car usage table' table."];
car_usage_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Car usage table' table."];
car_usage_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Car usage table' table, regardless of their owner."];

car_usage_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Car usage table' table."];
car_usage_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Car usage table' table."];
car_usage_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Car usage table' table."];
car_usage_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Car usage table' table."];

// cycle_table table
cycle_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Cycle - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

cycle_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Cycle - App' table."];
cycle_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Cycle - App' table."];
cycle_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Cycle - App' table."];
cycle_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Cycle - App' table."];

cycle_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Cycle - App' table."];
cycle_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Cycle - App' table."];
cycle_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Cycle - App' table."];
cycle_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Cycle - App' table, regardless of their owner."];

cycle_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Cycle - App' table."];
cycle_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Cycle - App' table."];
cycle_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Cycle - App' table."];
cycle_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Cycle - App' table."];

// cycle_usage_table table
cycle_usage_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Cycle usage table' table. A member who adds a record to the table becomes the 'owner' of that record."];

cycle_usage_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Cycle usage table' table."];
cycle_usage_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Cycle usage table' table."];
cycle_usage_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Cycle usage table' table."];
cycle_usage_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Cycle usage table' table."];

cycle_usage_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Cycle usage table' table."];
cycle_usage_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Cycle usage table' table."];
cycle_usage_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Cycle usage table' table."];
cycle_usage_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Cycle usage table' table, regardless of their owner."];

cycle_usage_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Cycle usage table' table."];
cycle_usage_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Cycle usage table' table."];
cycle_usage_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Cycle usage table' table."];
cycle_usage_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Cycle usage table' table."];

// gym_table table
gym_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Gym - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

gym_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Gym - App' table."];
gym_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Gym - App' table."];
gym_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Gym - App' table."];
gym_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Gym - App' table."];

gym_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Gym - App' table."];
gym_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Gym - App' table."];
gym_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Gym - App' table."];
gym_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Gym - App' table, regardless of their owner."];

gym_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Gym - App' table."];
gym_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Gym - App' table."];
gym_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Gym - App' table."];
gym_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Gym - App' table."];

// coffee_table table
coffee_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Coffee - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

coffee_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Coffee - App' table."];
coffee_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Coffee - App' table."];
coffee_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Coffee - App' table."];
coffee_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Coffee - App' table."];

coffee_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Coffee - App' table."];
coffee_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Coffee - App' table."];
coffee_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Coffee - App' table."];
coffee_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Coffee - App' table, regardless of their owner."];

coffee_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Coffee - App' table."];
coffee_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Coffee - App' table."];
coffee_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Coffee - App' table."];
coffee_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Coffee - App' table."];

// cafeteria_table table
cafeteria_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Cafeteria - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

cafeteria_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Cafeteria - App' table."];
cafeteria_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Cafeteria - App' table."];
cafeteria_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Cafeteria - App' table."];
cafeteria_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Cafeteria - App' table."];

cafeteria_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Cafeteria - App' table."];
cafeteria_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Cafeteria - App' table."];
cafeteria_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Cafeteria - App' table."];
cafeteria_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Cafeteria - App' table, regardless of their owner."];

cafeteria_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Cafeteria - App' table."];
cafeteria_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Cafeteria - App' table."];
cafeteria_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Cafeteria - App' table."];
cafeteria_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Cafeteria - App' table."];

// event_table table
event_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Event - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

event_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Event - App' table."];
event_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Event - App' table."];
event_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Event - App' table."];
event_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Event - App' table."];

event_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Event - App' table."];
event_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Event - App' table."];
event_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Event - App' table."];
event_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Event - App' table, regardless of their owner."];

event_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Event - App' table."];
event_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Event - App' table."];
event_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Event - App' table."];
event_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Event - App' table."];

// outcomes_expected_table table
outcomes_expected_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Outcomes Expected Table' table. A member who adds a record to the table becomes the 'owner' of that record."];

outcomes_expected_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Outcomes Expected Table' table."];
outcomes_expected_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Outcomes Expected Table' table."];
outcomes_expected_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Outcomes Expected Table' table."];
outcomes_expected_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Outcomes Expected Table' table."];

outcomes_expected_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Outcomes Expected Table' table."];
outcomes_expected_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Outcomes Expected Table' table."];
outcomes_expected_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Outcomes Expected Table' table."];
outcomes_expected_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Outcomes Expected Table' table, regardless of their owner."];

outcomes_expected_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Outcomes Expected Table' table."];
outcomes_expected_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Outcomes Expected Table' table."];
outcomes_expected_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Outcomes Expected Table' table."];
outcomes_expected_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Outcomes Expected Table' table."];

// event_decision_table table
event_decision_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Decision - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

event_decision_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Decision - App' table."];
event_decision_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Decision - App' table."];
event_decision_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Decision - App' table."];
event_decision_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Decision - App' table."];

event_decision_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Decision - App' table."];
event_decision_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Decision - App' table."];
event_decision_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Decision - App' table."];
event_decision_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Decision - App' table, regardless of their owner."];

event_decision_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Decision - App' table."];
event_decision_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Decision - App' table."];
event_decision_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Decision - App' table."];
event_decision_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Decision - App' table."];

// meetings_table table
meetings_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Meetings - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

meetings_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Meetings - App' table."];
meetings_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Meetings - App' table."];
meetings_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Meetings - App' table."];
meetings_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Meetings - App' table."];

meetings_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Meetings - App' table."];
meetings_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Meetings - App' table."];
meetings_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Meetings - App' table."];
meetings_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Meetings - App' table, regardless of their owner."];

meetings_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Meetings - App' table."];
meetings_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Meetings - App' table."];
meetings_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Meetings - App' table."];
meetings_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Meetings - App' table."];

// agenda_table table
agenda_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Agenda - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

agenda_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Agenda - App' table."];
agenda_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Agenda - App' table."];
agenda_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Agenda - App' table."];
agenda_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Agenda - App' table."];

agenda_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Agenda - App' table."];
agenda_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Agenda - App' table."];
agenda_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Agenda - App' table."];
agenda_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Agenda - App' table, regardless of their owner."];

agenda_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Agenda - App' table."];
agenda_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Agenda - App' table."];
agenda_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Agenda - App' table."];
agenda_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Agenda - App' table."];

// decision_table table
decision_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Decision - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

decision_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Decision - App' table."];
decision_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Decision - App' table."];
decision_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Decision - App' table."];
decision_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Decision - App' table."];

decision_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Decision - App' table."];
decision_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Decision - App' table."];
decision_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Decision - App' table."];
decision_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Decision - App' table, regardless of their owner."];

decision_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Decision - App' table."];
decision_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Decision - App' table."];
decision_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Decision - App' table."];
decision_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Decision - App' table."];

// participants_table table
participants_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Participants / Speaker / VIP List - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

participants_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Participants / Speaker / VIP List - App' table."];
participants_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Participants / Speaker / VIP List - App' table."];
participants_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Participants / Speaker / VIP List - App' table."];
participants_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Participants / Speaker / VIP List - App' table."];

participants_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Participants / Speaker / VIP List - App' table."];
participants_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Participants / Speaker / VIP List - App' table."];
participants_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Participants / Speaker / VIP List - App' table."];
participants_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Participants / Speaker / VIP List - App' table, regardless of their owner."];

participants_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Participants / Speaker / VIP List - App' table."];
participants_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Participants / Speaker / VIP List - App' table."];
participants_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Participants / Speaker / VIP List - App' table."];
participants_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Participants / Speaker / VIP List - App' table."];

// action_actor table
action_actor_addTip=["",spacer+"This option allows all members of the group to add records to the 'Action actor' table. A member who adds a record to the table becomes the 'owner' of that record."];

action_actor_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Action actor' table."];
action_actor_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Action actor' table."];
action_actor_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Action actor' table."];
action_actor_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Action actor' table."];

action_actor_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Action actor' table."];
action_actor_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Action actor' table."];
action_actor_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Action actor' table."];
action_actor_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Action actor' table, regardless of their owner."];

action_actor_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Action actor' table."];
action_actor_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Action actor' table."];
action_actor_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Action actor' table."];
action_actor_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Action actor' table."];

// visiting_card_table table
visiting_card_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Visiting card - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

visiting_card_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Visiting card - App' table."];
visiting_card_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Visiting card - App' table."];
visiting_card_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Visiting card - App' table."];
visiting_card_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Visiting card - App' table."];

visiting_card_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Visiting card - App' table."];
visiting_card_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Visiting card - App' table."];
visiting_card_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Visiting card - App' table."];
visiting_card_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Visiting card - App' table, regardless of their owner."];

visiting_card_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Visiting card - App' table."];
visiting_card_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Visiting card - App' table."];
visiting_card_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Visiting card - App' table."];
visiting_card_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Visiting card - App' table."];

// mou_details_table table
mou_details_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'MoU Details - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

mou_details_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'MoU Details - App' table."];
mou_details_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'MoU Details - App' table."];
mou_details_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'MoU Details - App' table."];
mou_details_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'MoU Details - App' table."];

mou_details_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'MoU Details - App' table."];
mou_details_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'MoU Details - App' table."];
mou_details_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'MoU Details - App' table."];
mou_details_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'MoU Details - App' table, regardless of their owner."];

mou_details_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'MoU Details - App' table."];
mou_details_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'MoU Details - App' table."];
mou_details_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'MoU Details - App' table."];
mou_details_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'MoU Details - App' table."];

// goal_setting_table table
goal_setting_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Goal setting - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

goal_setting_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Goal setting - App' table."];
goal_setting_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Goal setting - App' table."];
goal_setting_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Goal setting - App' table."];
goal_setting_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Goal setting - App' table."];

goal_setting_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Goal setting - App' table."];
goal_setting_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Goal setting - App' table."];
goal_setting_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Goal setting - App' table."];
goal_setting_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Goal setting - App' table, regardless of their owner."];

goal_setting_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Goal setting - App' table."];
goal_setting_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Goal setting - App' table."];
goal_setting_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Goal setting - App' table."];
goal_setting_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Goal setting - App' table."];

// goal_progress_table table
goal_progress_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Goal progress table' table. A member who adds a record to the table becomes the 'owner' of that record."];

goal_progress_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Goal progress table' table."];
goal_progress_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Goal progress table' table."];
goal_progress_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Goal progress table' table."];
goal_progress_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Goal progress table' table."];

goal_progress_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Goal progress table' table."];
goal_progress_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Goal progress table' table."];
goal_progress_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Goal progress table' table."];
goal_progress_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Goal progress table' table, regardless of their owner."];

goal_progress_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Goal progress table' table."];
goal_progress_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Goal progress table' table."];
goal_progress_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Goal progress table' table."];
goal_progress_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Goal progress table' table."];

// task_allocation_table table
task_allocation_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Task Allocation - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

task_allocation_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Task Allocation - App' table."];
task_allocation_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Task Allocation - App' table."];
task_allocation_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Task Allocation - App' table."];
task_allocation_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Task Allocation - App' table."];

task_allocation_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Task Allocation - App' table."];
task_allocation_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Task Allocation - App' table."];
task_allocation_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Task Allocation - App' table."];
task_allocation_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Task Allocation - App' table, regardless of their owner."];

task_allocation_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Task Allocation - App' table."];
task_allocation_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Task Allocation - App' table."];
task_allocation_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Task Allocation - App' table."];
task_allocation_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Task Allocation - App' table."];

// task_progress_status_table table
task_progress_status_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Task Progress Status - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

task_progress_status_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Task Progress Status - App' table."];
task_progress_status_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Task Progress Status - App' table."];
task_progress_status_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Task Progress Status - App' table."];
task_progress_status_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Task Progress Status - App' table."];

task_progress_status_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Task Progress Status - App' table."];
task_progress_status_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Task Progress Status - App' table."];
task_progress_status_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Task Progress Status - App' table."];
task_progress_status_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Task Progress Status - App' table, regardless of their owner."];

task_progress_status_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Task Progress Status - App' table."];
task_progress_status_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Task Progress Status - App' table."];
task_progress_status_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Task Progress Status - App' table."];
task_progress_status_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Task Progress Status - App' table."];

// timesheet_entry_table table
timesheet_entry_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Timesheet Entry - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

timesheet_entry_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Timesheet Entry - App' table."];
timesheet_entry_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Timesheet Entry - App' table."];
timesheet_entry_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Timesheet Entry - App' table."];
timesheet_entry_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Timesheet Entry - App' table."];

timesheet_entry_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Timesheet Entry - App' table."];
timesheet_entry_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Timesheet Entry - App' table."];
timesheet_entry_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Timesheet Entry - App' table."];
timesheet_entry_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Timesheet Entry - App' table, regardless of their owner."];

timesheet_entry_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Timesheet Entry - App' table."];
timesheet_entry_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Timesheet Entry - App' table."];
timesheet_entry_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Timesheet Entry - App' table."];
timesheet_entry_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Timesheet Entry - App' table."];

// internship_fellowship_details_app table
internship_fellowship_details_app_addTip=["",spacer+"This option allows all members of the group to add records to the 'Internship/Fellowship details - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

internship_fellowship_details_app_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Internship/Fellowship details - App' table."];
internship_fellowship_details_app_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Internship/Fellowship details - App' table."];
internship_fellowship_details_app_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Internship/Fellowship details - App' table."];
internship_fellowship_details_app_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Internship/Fellowship details - App' table."];

internship_fellowship_details_app_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Internship/Fellowship details - App' table."];
internship_fellowship_details_app_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Internship/Fellowship details - App' table."];
internship_fellowship_details_app_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Internship/Fellowship details - App' table."];
internship_fellowship_details_app_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Internship/Fellowship details - App' table, regardless of their owner."];

internship_fellowship_details_app_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Internship/Fellowship details - App' table."];
internship_fellowship_details_app_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Internship/Fellowship details - App' table."];
internship_fellowship_details_app_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Internship/Fellowship details - App' table."];
internship_fellowship_details_app_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Internship/Fellowship details - App' table."];

// star_pnt table
star_pnt_addTip=["",spacer+"This option allows all members of the group to add records to the 'Star-PNT - APP' table. A member who adds a record to the table becomes the 'owner' of that record."];

star_pnt_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Star-PNT - APP' table."];
star_pnt_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Star-PNT - APP' table."];
star_pnt_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Star-PNT - APP' table."];
star_pnt_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Star-PNT - APP' table."];

star_pnt_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Star-PNT - APP' table."];
star_pnt_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Star-PNT - APP' table."];
star_pnt_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Star-PNT - APP' table."];
star_pnt_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Star-PNT - APP' table, regardless of their owner."];

star_pnt_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Star-PNT - APP' table."];
star_pnt_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Star-PNT - APP' table."];
star_pnt_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Star-PNT - APP' table."];
star_pnt_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Star-PNT - APP' table."];

// hrd_sdp_events_table table
hrd_sdp_events_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'HRD & SDP Events - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

hrd_sdp_events_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'HRD & SDP Events - App' table."];
hrd_sdp_events_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'HRD & SDP Events - App' table."];
hrd_sdp_events_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'HRD & SDP Events - App' table."];
hrd_sdp_events_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'HRD & SDP Events - App' table."];

hrd_sdp_events_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'HRD & SDP Events - App' table."];
hrd_sdp_events_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'HRD & SDP Events - App' table."];
hrd_sdp_events_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'HRD & SDP Events - App' table."];
hrd_sdp_events_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'HRD & SDP Events - App' table, regardless of their owner."];

hrd_sdp_events_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'HRD & SDP Events - App' table."];
hrd_sdp_events_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'HRD & SDP Events - App' table."];
hrd_sdp_events_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'HRD & SDP Events - App' table."];
hrd_sdp_events_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'HRD & SDP Events - App' table."];

// training_program_on_geospatial_tchnologies_table table
training_program_on_geospatial_tchnologies_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Training Program on Geospatial Technologies Details - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

training_program_on_geospatial_tchnologies_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Training Program on Geospatial Technologies Details - App' table."];
training_program_on_geospatial_tchnologies_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Training Program on Geospatial Technologies Details - App' table."];
training_program_on_geospatial_tchnologies_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Training Program on Geospatial Technologies Details - App' table."];
training_program_on_geospatial_tchnologies_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Training Program on Geospatial Technologies Details - App' table."];

training_program_on_geospatial_tchnologies_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Training Program on Geospatial Technologies Details - App' table."];
training_program_on_geospatial_tchnologies_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Training Program on Geospatial Technologies Details - App' table."];
training_program_on_geospatial_tchnologies_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Training Program on Geospatial Technologies Details - App' table."];
training_program_on_geospatial_tchnologies_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Training Program on Geospatial Technologies Details - App' table, regardless of their owner."];

training_program_on_geospatial_tchnologies_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Training Program on Geospatial Technologies Details - App' table."];
training_program_on_geospatial_tchnologies_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Training Program on Geospatial Technologies Details - App' table."];
training_program_on_geospatial_tchnologies_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Training Program on Geospatial Technologies Details - App' table."];
training_program_on_geospatial_tchnologies_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Training Program on Geospatial Technologies Details - App' table."];

// space_day_school_details_app table
space_day_school_details_app_addTip=["",spacer+"This option allows all members of the group to add records to the 'Space day school student details app' table. A member who adds a record to the table becomes the 'owner' of that record."];

space_day_school_details_app_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Space day school student details app' table."];
space_day_school_details_app_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Space day school student details app' table."];
space_day_school_details_app_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Space day school student details app' table."];
space_day_school_details_app_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Space day school student details app' table."];

space_day_school_details_app_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Space day school student details app' table."];
space_day_school_details_app_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Space day school student details app' table."];
space_day_school_details_app_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Space day school student details app' table."];
space_day_school_details_app_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Space day school student details app' table, regardless of their owner."];

space_day_school_details_app_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Space day school student details app' table."];
space_day_school_details_app_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Space day school student details app' table."];
space_day_school_details_app_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Space day school student details app' table."];
space_day_school_details_app_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Space day school student details app' table."];

// space_day_college_student_table table
space_day_college_student_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Space day college student - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

space_day_college_student_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Space day college student - App' table."];
space_day_college_student_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Space day college student - App' table."];
space_day_college_student_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Space day college student - App' table."];
space_day_college_student_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Space day college student - App' table."];

space_day_college_student_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Space day college student - App' table."];
space_day_college_student_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Space day college student - App' table."];
space_day_college_student_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Space day college student - App' table."];
space_day_college_student_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Space day college student - App' table, regardless of their owner."];

space_day_college_student_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Space day college student - App' table."];
space_day_college_student_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Space day college student - App' table."];
space_day_college_student_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Space day college student - App' table."];
space_day_college_student_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Space day college student - App' table."];

// school_list table
school_list_addTip=["",spacer+"This option allows all members of the group to add records to the 'School List - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

school_list_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'School List - App' table."];
school_list_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'School List - App' table."];
school_list_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'School List - App' table."];
school_list_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'School List - App' table."];

school_list_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'School List - App' table."];
school_list_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'School List - App' table."];
school_list_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'School List - App' table."];
school_list_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'School List - App' table, regardless of their owner."];

school_list_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'School List - App' table."];
school_list_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'School List - App' table."];
school_list_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'School List - App' table."];
school_list_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'School List - App' table."];

// sdp_participants_college_details_table table
sdp_participants_college_details_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'SDP participants college details - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

sdp_participants_college_details_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'SDP participants college details - App' table."];
sdp_participants_college_details_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'SDP participants college details - App' table."];
sdp_participants_college_details_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'SDP participants college details - App' table."];
sdp_participants_college_details_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'SDP participants college details - App' table."];

sdp_participants_college_details_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'SDP participants college details - App' table."];
sdp_participants_college_details_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'SDP participants college details - App' table."];
sdp_participants_college_details_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'SDP participants college details - App' table."];
sdp_participants_college_details_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'SDP participants college details - App' table, regardless of their owner."];

sdp_participants_college_details_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'SDP participants college details - App' table."];
sdp_participants_college_details_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'SDP participants college details - App' table."];
sdp_participants_college_details_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'SDP participants college details - App' table."];
sdp_participants_college_details_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'SDP participants college details - App' table."];

// asset_table table
asset_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Master Inventory (Admin Department) - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

asset_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Master Inventory (Admin Department) - App' table."];
asset_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Master Inventory (Admin Department) - App' table."];
asset_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Master Inventory (Admin Department) - App' table."];
asset_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Master Inventory (Admin Department) - App' table."];

asset_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Master Inventory (Admin Department) - App' table."];
asset_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Master Inventory (Admin Department) - App' table."];
asset_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Master Inventory (Admin Department) - App' table."];
asset_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Master Inventory (Admin Department) - App' table, regardless of their owner."];

asset_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Master Inventory (Admin Department) - App' table."];
asset_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Master Inventory (Admin Department) - App' table."];
asset_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Master Inventory (Admin Department) - App' table."];
asset_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Master Inventory (Admin Department) - App' table."];

// asset_allotment_table table
asset_allotment_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Master Inventory Allotment - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

asset_allotment_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Master Inventory Allotment - App' table."];
asset_allotment_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Master Inventory Allotment - App' table."];
asset_allotment_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Master Inventory Allotment - App' table."];
asset_allotment_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Master Inventory Allotment - App' table."];

asset_allotment_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Master Inventory Allotment - App' table."];
asset_allotment_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Master Inventory Allotment - App' table."];
asset_allotment_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Master Inventory Allotment - App' table."];
asset_allotment_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Master Inventory Allotment - App' table, regardless of their owner."];

asset_allotment_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Master Inventory Allotment - App' table."];
asset_allotment_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Master Inventory Allotment - App' table."];
asset_allotment_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Master Inventory Allotment - App' table."];
asset_allotment_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Master Inventory Allotment - App' table."];

// sub_asset_table table
sub_asset_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Sub Inventory (Technical Department) - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

sub_asset_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Sub Inventory (Technical Department) - App' table."];
sub_asset_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Sub Inventory (Technical Department) - App' table."];
sub_asset_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Sub Inventory (Technical Department) - App' table."];
sub_asset_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Sub Inventory (Technical Department) - App' table."];

sub_asset_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Sub Inventory (Technical Department) - App' table."];
sub_asset_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Sub Inventory (Technical Department) - App' table."];
sub_asset_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Sub Inventory (Technical Department) - App' table."];
sub_asset_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Sub Inventory (Technical Department) - App' table, regardless of their owner."];

sub_asset_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Sub Inventory (Technical Department) - App' table."];
sub_asset_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Sub Inventory (Technical Department) - App' table."];
sub_asset_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Sub Inventory (Technical Department) - App' table."];
sub_asset_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Sub Inventory (Technical Department) - App' table."];

// sub_asset_allotment_table table
sub_asset_allotment_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Sub Inventory Allotment - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

sub_asset_allotment_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Sub Inventory Allotment - App' table."];
sub_asset_allotment_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Sub Inventory Allotment - App' table."];
sub_asset_allotment_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Sub Inventory Allotment - App' table."];
sub_asset_allotment_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Sub Inventory Allotment - App' table."];

sub_asset_allotment_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Sub Inventory Allotment - App' table."];
sub_asset_allotment_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Sub Inventory Allotment - App' table."];
sub_asset_allotment_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Sub Inventory Allotment - App' table."];
sub_asset_allotment_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Sub Inventory Allotment - App' table, regardless of their owner."];

sub_asset_allotment_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Sub Inventory Allotment - App' table."];
sub_asset_allotment_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Sub Inventory Allotment - App' table."];
sub_asset_allotment_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Sub Inventory Allotment - App' table."];
sub_asset_allotment_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Sub Inventory Allotment - App' table."];

// it_inventory_app table
it_inventory_app_addTip=["",spacer+"This option allows all members of the group to add records to the 'IT inventory - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

it_inventory_app_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'IT inventory - App' table."];
it_inventory_app_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'IT inventory - App' table."];
it_inventory_app_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'IT inventory - App' table."];
it_inventory_app_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'IT inventory - App' table."];

it_inventory_app_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'IT inventory - App' table."];
it_inventory_app_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'IT inventory - App' table."];
it_inventory_app_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'IT inventory - App' table."];
it_inventory_app_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'IT inventory - App' table, regardless of their owner."];

it_inventory_app_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'IT inventory - App' table."];
it_inventory_app_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'IT inventory - App' table."];
it_inventory_app_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'IT inventory - App' table."];
it_inventory_app_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'IT inventory - App' table."];

// it_inventory_billing_details table
it_inventory_billing_details_addTip=["",spacer+"This option allows all members of the group to add records to the 'IT inventory billing details - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

it_inventory_billing_details_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'IT inventory billing details - App' table."];
it_inventory_billing_details_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'IT inventory billing details - App' table."];
it_inventory_billing_details_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'IT inventory billing details - App' table."];
it_inventory_billing_details_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'IT inventory billing details - App' table."];

it_inventory_billing_details_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'IT inventory billing details - App' table."];
it_inventory_billing_details_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'IT inventory billing details - App' table."];
it_inventory_billing_details_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'IT inventory billing details - App' table."];
it_inventory_billing_details_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'IT inventory billing details - App' table, regardless of their owner."];

it_inventory_billing_details_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'IT inventory billing details - App' table."];
it_inventory_billing_details_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'IT inventory billing details - App' table."];
it_inventory_billing_details_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'IT inventory billing details - App' table."];
it_inventory_billing_details_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'IT inventory billing details - App' table."];

// it_inventory_allotment_table table
it_inventory_allotment_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'IT inventory Allotment - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

it_inventory_allotment_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'IT inventory Allotment - App' table."];
it_inventory_allotment_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'IT inventory Allotment - App' table."];
it_inventory_allotment_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'IT inventory Allotment - App' table."];
it_inventory_allotment_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'IT inventory Allotment - App' table."];

it_inventory_allotment_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'IT inventory Allotment - App' table."];
it_inventory_allotment_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'IT inventory Allotment - App' table."];
it_inventory_allotment_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'IT inventory Allotment - App' table."];
it_inventory_allotment_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'IT inventory Allotment - App' table, regardless of their owner."];

it_inventory_allotment_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'IT inventory Allotment - App' table."];
it_inventory_allotment_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'IT inventory Allotment - App' table."];
it_inventory_allotment_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'IT inventory Allotment - App' table."];
it_inventory_allotment_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'IT inventory Allotment - App' table."];

// computer_details_table table
computer_details_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Computer lab PC list - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

computer_details_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Computer lab PC list - App' table."];
computer_details_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Computer lab PC list - App' table."];
computer_details_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Computer lab PC list - App' table."];
computer_details_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Computer lab PC list - App' table."];

computer_details_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Computer lab PC list - App' table."];
computer_details_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Computer lab PC list - App' table."];
computer_details_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Computer lab PC list - App' table."];
computer_details_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Computer lab PC list - App' table, regardless of their owner."];

computer_details_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Computer lab PC list - App' table."];
computer_details_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Computer lab PC list - App' table."];
computer_details_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Computer lab PC list - App' table."];
computer_details_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Computer lab PC list - App' table."];

// computer_user_details table
computer_user_details_addTip=["",spacer+"This option allows all members of the group to add records to the 'Computer Uses Entry Table' table. A member who adds a record to the table becomes the 'owner' of that record."];

computer_user_details_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Computer Uses Entry Table' table."];
computer_user_details_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Computer Uses Entry Table' table."];
computer_user_details_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Computer Uses Entry Table' table."];
computer_user_details_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Computer Uses Entry Table' table."];

computer_user_details_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Computer Uses Entry Table' table."];
computer_user_details_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Computer Uses Entry Table' table."];
computer_user_details_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Computer Uses Entry Table' table."];
computer_user_details_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Computer Uses Entry Table' table, regardless of their owner."];

computer_user_details_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Computer Uses Entry Table' table."];
computer_user_details_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Computer Uses Entry Table' table."];
computer_user_details_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Computer Uses Entry Table' table."];
computer_user_details_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Computer Uses Entry Table' table."];

// computer_allotment_table table
computer_allotment_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'PC Allotment Table' table. A member who adds a record to the table becomes the 'owner' of that record."];

computer_allotment_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'PC Allotment Table' table."];
computer_allotment_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'PC Allotment Table' table."];
computer_allotment_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'PC Allotment Table' table."];
computer_allotment_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'PC Allotment Table' table."];

computer_allotment_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'PC Allotment Table' table."];
computer_allotment_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'PC Allotment Table' table."];
computer_allotment_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'PC Allotment Table' table."];
computer_allotment_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'PC Allotment Table' table, regardless of their owner."];

computer_allotment_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'PC Allotment Table' table."];
computer_allotment_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'PC Allotment Table' table."];
computer_allotment_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'PC Allotment Table' table."];
computer_allotment_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'PC Allotment Table' table."];

// employees_personal_data_table table
employees_personal_data_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Employee Personal Data - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

employees_personal_data_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Employee Personal Data - App' table."];
employees_personal_data_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Employee Personal Data - App' table."];
employees_personal_data_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Employee Personal Data - App' table."];
employees_personal_data_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Employee Personal Data - App' table."];

employees_personal_data_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Employee Personal Data - App' table."];
employees_personal_data_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Employee Personal Data - App' table."];
employees_personal_data_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Employee Personal Data - App' table."];
employees_personal_data_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Employee Personal Data - App' table, regardless of their owner."];

employees_personal_data_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Employee Personal Data - App' table."];
employees_personal_data_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Employee Personal Data - App' table."];
employees_personal_data_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Employee Personal Data - App' table."];
employees_personal_data_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Employee Personal Data - App' table."];

// employees_designation_table table
employees_designation_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Employees designation & Reporting - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

employees_designation_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Employees designation & Reporting - App' table."];
employees_designation_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Employees designation & Reporting - App' table."];
employees_designation_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Employees designation & Reporting - App' table."];
employees_designation_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Employees designation & Reporting - App' table."];

employees_designation_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Employees designation & Reporting - App' table."];
employees_designation_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Employees designation & Reporting - App' table."];
employees_designation_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Employees designation & Reporting - App' table."];
employees_designation_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Employees designation & Reporting - App' table, regardless of their owner."];

employees_designation_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Employees designation & Reporting - App' table."];
employees_designation_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Employees designation & Reporting - App' table."];
employees_designation_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Employees designation & Reporting - App' table."];
employees_designation_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Employees designation & Reporting - App' table."];

// employees_appraisal_table table
employees_appraisal_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Employees Appraisal  - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

employees_appraisal_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Employees Appraisal  - App' table."];
employees_appraisal_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Employees Appraisal  - App' table."];
employees_appraisal_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Employees Appraisal  - App' table."];
employees_appraisal_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Employees Appraisal  - App' table."];

employees_appraisal_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Employees Appraisal  - App' table."];
employees_appraisal_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Employees Appraisal  - App' table."];
employees_appraisal_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Employees Appraisal  - App' table."];
employees_appraisal_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Employees Appraisal  - App' table, regardless of their owner."];

employees_appraisal_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Employees Appraisal  - App' table."];
employees_appraisal_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Employees Appraisal  - App' table."];
employees_appraisal_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Employees Appraisal  - App' table."];
employees_appraisal_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Employees Appraisal  - App' table."];

// beyond_working_hours_table table
beyond_working_hours_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Beyond Working Hours Approval - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

beyond_working_hours_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Beyond Working Hours Approval - App' table."];
beyond_working_hours_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Beyond Working Hours Approval - App' table."];
beyond_working_hours_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Beyond Working Hours Approval - App' table."];
beyond_working_hours_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Beyond Working Hours Approval - App' table."];

beyond_working_hours_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Beyond Working Hours Approval - App' table."];
beyond_working_hours_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Beyond Working Hours Approval - App' table."];
beyond_working_hours_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Beyond Working Hours Approval - App' table."];
beyond_working_hours_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Beyond Working Hours Approval - App' table, regardless of their owner."];

beyond_working_hours_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Beyond Working Hours Approval - App' table."];
beyond_working_hours_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Beyond Working Hours Approval - App' table."];
beyond_working_hours_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Beyond Working Hours Approval - App' table."];
beyond_working_hours_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Beyond Working Hours Approval - App' table."];

// leave_table table
leave_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Leave - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

leave_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Leave - App' table."];
leave_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Leave - App' table."];
leave_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Leave - App' table."];
leave_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Leave - App' table."];

leave_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Leave - App' table."];
leave_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Leave - App' table."];
leave_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Leave - App' table."];
leave_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Leave - App' table, regardless of their owner."];

leave_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Leave - App' table."];
leave_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Leave - App' table."];
leave_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Leave - App' table."];
leave_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Leave - App' table."];

// half_day_leave_table table
half_day_leave_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Half Day Leave - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

half_day_leave_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Half Day Leave - App' table."];
half_day_leave_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Half Day Leave - App' table."];
half_day_leave_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Half Day Leave - App' table."];
half_day_leave_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Half Day Leave - App' table."];

half_day_leave_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Half Day Leave - App' table."];
half_day_leave_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Half Day Leave - App' table."];
half_day_leave_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Half Day Leave - App' table."];
half_day_leave_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Half Day Leave - App' table, regardless of their owner."];

half_day_leave_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Half Day Leave - App' table."];
half_day_leave_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Half Day Leave - App' table."];
half_day_leave_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Half Day Leave - App' table."];
half_day_leave_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Half Day Leave - App' table."];

// work_from_home_table table
work_from_home_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Work From Home - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

work_from_home_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Work From Home - App' table."];
work_from_home_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Work From Home - App' table."];
work_from_home_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Work From Home - App' table."];
work_from_home_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Work From Home - App' table."];

work_from_home_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Work From Home - App' table."];
work_from_home_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Work From Home - App' table."];
work_from_home_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Work From Home - App' table."];
work_from_home_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Work From Home - App' table, regardless of their owner."];

work_from_home_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Work From Home - App' table."];
work_from_home_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Work From Home - App' table."];
work_from_home_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Work From Home - App' table."];
work_from_home_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Work From Home - App' table."];

// work_from_home_tasks_app table
work_from_home_tasks_app_addTip=["",spacer+"This option allows all members of the group to add records to the 'Tasks' table. A member who adds a record to the table becomes the 'owner' of that record."];

work_from_home_tasks_app_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Tasks' table."];
work_from_home_tasks_app_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Tasks' table."];
work_from_home_tasks_app_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Tasks' table."];
work_from_home_tasks_app_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Tasks' table."];

work_from_home_tasks_app_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Tasks' table."];
work_from_home_tasks_app_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Tasks' table."];
work_from_home_tasks_app_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Tasks' table."];
work_from_home_tasks_app_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Tasks' table, regardless of their owner."];

work_from_home_tasks_app_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Tasks' table."];
work_from_home_tasks_app_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Tasks' table."];
work_from_home_tasks_app_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Tasks' table."];
work_from_home_tasks_app_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Tasks' table."];

// navavishkar_stay_table table
navavishkar_stay_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Navavishkar Stay - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

navavishkar_stay_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Navavishkar Stay - App' table."];
navavishkar_stay_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Navavishkar Stay - App' table."];
navavishkar_stay_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Navavishkar Stay - App' table."];
navavishkar_stay_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Navavishkar Stay - App' table."];

navavishkar_stay_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Navavishkar Stay - App' table."];
navavishkar_stay_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Navavishkar Stay - App' table."];
navavishkar_stay_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Navavishkar Stay - App' table."];
navavishkar_stay_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Navavishkar Stay - App' table, regardless of their owner."];

navavishkar_stay_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Navavishkar Stay - App' table."];
navavishkar_stay_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Navavishkar Stay - App' table."];
navavishkar_stay_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Navavishkar Stay - App' table."];
navavishkar_stay_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Navavishkar Stay - App' table."];

// navavishkar_stay_payment_table table
navavishkar_stay_payment_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Navavishkar Stay Payment - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

navavishkar_stay_payment_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Navavishkar Stay Payment - App' table."];
navavishkar_stay_payment_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Navavishkar Stay Payment - App' table."];
navavishkar_stay_payment_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Navavishkar Stay Payment - App' table."];
navavishkar_stay_payment_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Navavishkar Stay Payment - App' table."];

navavishkar_stay_payment_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Navavishkar Stay Payment - App' table."];
navavishkar_stay_payment_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Navavishkar Stay Payment - App' table."];
navavishkar_stay_payment_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Navavishkar Stay Payment - App' table."];
navavishkar_stay_payment_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Navavishkar Stay Payment - App' table, regardless of their owner."];

navavishkar_stay_payment_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Navavishkar Stay Payment - App' table."];
navavishkar_stay_payment_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Navavishkar Stay Payment - App' table."];
navavishkar_stay_payment_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Navavishkar Stay Payment - App' table."];
navavishkar_stay_payment_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Navavishkar Stay Payment - App' table."];

// email_id_allocation_table table
email_id_allocation_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Email id allocation - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

email_id_allocation_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Email id allocation - App' table."];
email_id_allocation_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Email id allocation - App' table."];
email_id_allocation_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Email id allocation - App' table."];
email_id_allocation_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Email id allocation - App' table."];

email_id_allocation_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Email id allocation - App' table."];
email_id_allocation_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Email id allocation - App' table."];
email_id_allocation_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Email id allocation - App' table."];
email_id_allocation_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Email id allocation - App' table, regardless of their owner."];

email_id_allocation_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Email id allocation - App' table."];
email_id_allocation_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Email id allocation - App' table."];
email_id_allocation_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Email id allocation - App' table."];
email_id_allocation_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Email id allocation - App' table."];

// attendence_details_table table
attendence_details_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Attendence details - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

attendence_details_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Attendence details - App' table."];
attendence_details_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Attendence details - App' table."];
attendence_details_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Attendence details - App' table."];
attendence_details_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Attendence details - App' table."];

attendence_details_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Attendence details - App' table."];
attendence_details_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Attendence details - App' table."];
attendence_details_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Attendence details - App' table."];
attendence_details_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Attendence details - App' table, regardless of their owner."];

attendence_details_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Attendence details - App' table."];
attendence_details_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Attendence details - App' table."];
attendence_details_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Attendence details - App' table."];
attendence_details_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Attendence details - App' table."];

// all_startup_data_table table
all_startup_data_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'All Startups Data - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

all_startup_data_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'All Startups Data - App' table."];
all_startup_data_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'All Startups Data - App' table."];
all_startup_data_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'All Startups Data - App' table."];
all_startup_data_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'All Startups Data - App' table."];

all_startup_data_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'All Startups Data - App' table."];
all_startup_data_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'All Startups Data - App' table."];
all_startup_data_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'All Startups Data - App' table."];
all_startup_data_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'All Startups Data - App' table, regardless of their owner."];

all_startup_data_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'All Startups Data - App' table."];
all_startup_data_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'All Startups Data - App' table."];
all_startup_data_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'All Startups Data - App' table."];
all_startup_data_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'All Startups Data - App' table."];

// shortlisted_startups_for_fund_table table
shortlisted_startups_for_fund_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Shortlisted startups for fund - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

shortlisted_startups_for_fund_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Shortlisted startups for fund - App' table."];
shortlisted_startups_for_fund_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Shortlisted startups for fund - App' table."];
shortlisted_startups_for_fund_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Shortlisted startups for fund - App' table."];
shortlisted_startups_for_fund_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Shortlisted startups for fund - App' table."];

shortlisted_startups_for_fund_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Shortlisted startups for fund - App' table."];
shortlisted_startups_for_fund_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Shortlisted startups for fund - App' table."];
shortlisted_startups_for_fund_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Shortlisted startups for fund - App' table."];
shortlisted_startups_for_fund_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Shortlisted startups for fund - App' table, regardless of their owner."];

shortlisted_startups_for_fund_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Shortlisted startups for fund - App' table."];
shortlisted_startups_for_fund_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Shortlisted startups for fund - App' table."];
shortlisted_startups_for_fund_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Shortlisted startups for fund - App' table."];
shortlisted_startups_for_fund_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Shortlisted startups for fund - App' table."];

// shortlisted_startups_dd_and_agreement_table table
shortlisted_startups_dd_and_agreement_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Shortlisted startups DD and Agreement - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

shortlisted_startups_dd_and_agreement_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Shortlisted startups DD and Agreement - App' table."];
shortlisted_startups_dd_and_agreement_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Shortlisted startups DD and Agreement - App' table."];
shortlisted_startups_dd_and_agreement_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Shortlisted startups DD and Agreement - App' table."];
shortlisted_startups_dd_and_agreement_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Shortlisted startups DD and Agreement - App' table."];

shortlisted_startups_dd_and_agreement_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Shortlisted startups DD and Agreement - App' table."];
shortlisted_startups_dd_and_agreement_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Shortlisted startups DD and Agreement - App' table."];
shortlisted_startups_dd_and_agreement_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Shortlisted startups DD and Agreement - App' table."];
shortlisted_startups_dd_and_agreement_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Shortlisted startups DD and Agreement - App' table, regardless of their owner."];

shortlisted_startups_dd_and_agreement_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Shortlisted startups DD and Agreement - App' table."];
shortlisted_startups_dd_and_agreement_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Shortlisted startups DD and Agreement - App' table."];
shortlisted_startups_dd_and_agreement_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Shortlisted startups DD and Agreement - App' table."];
shortlisted_startups_dd_and_agreement_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Shortlisted startups DD and Agreement - App' table."];

// vikas_startup_applications_table table
vikas_startup_applications_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Vikas startup applications - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

vikas_startup_applications_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Vikas startup applications - App' table."];
vikas_startup_applications_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Vikas startup applications - App' table."];
vikas_startup_applications_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Vikas startup applications - App' table."];
vikas_startup_applications_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Vikas startup applications - App' table."];

vikas_startup_applications_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Vikas startup applications - App' table."];
vikas_startup_applications_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Vikas startup applications - App' table."];
vikas_startup_applications_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Vikas startup applications - App' table."];
vikas_startup_applications_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Vikas startup applications - App' table, regardless of their owner."];

vikas_startup_applications_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Vikas startup applications - App' table."];
vikas_startup_applications_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Vikas startup applications - App' table."];
vikas_startup_applications_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Vikas startup applications - App' table."];
vikas_startup_applications_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Vikas startup applications - App' table."];

// programs_table table
programs_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Programs - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

programs_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Programs - App' table."];
programs_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Programs - App' table."];
programs_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Programs - App' table."];
programs_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Programs - App' table."];

programs_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Programs - App' table."];
programs_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Programs - App' table."];
programs_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Programs - App' table."];
programs_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Programs - App' table, regardless of their owner."];

programs_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Programs - App' table."];
programs_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Programs - App' table."];
programs_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Programs - App' table."];
programs_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Programs - App' table."];

// evaluation_table table
evaluation_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Evaluation table' table. A member who adds a record to the table becomes the 'owner' of that record."];

evaluation_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Evaluation table' table."];
evaluation_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Evaluation table' table."];
evaluation_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Evaluation table' table."];
evaluation_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Evaluation table' table."];

evaluation_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Evaluation table' table."];
evaluation_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Evaluation table' table."];
evaluation_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Evaluation table' table."];
evaluation_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Evaluation table' table, regardless of their owner."];

evaluation_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Evaluation table' table."];
evaluation_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Evaluation table' table."];
evaluation_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Evaluation table' table."];
evaluation_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Evaluation table' table."];

// problem_statement_table table
problem_statement_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Problem statement - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

problem_statement_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Problem statement - App' table."];
problem_statement_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Problem statement - App' table."];
problem_statement_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Problem statement - App' table."];
problem_statement_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Problem statement - App' table."];

problem_statement_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Problem statement - App' table."];
problem_statement_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Problem statement - App' table."];
problem_statement_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Problem statement - App' table."];
problem_statement_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Problem statement - App' table, regardless of their owner."];

problem_statement_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Problem statement - App' table."];
problem_statement_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Problem statement - App' table."];
problem_statement_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Problem statement - App' table."];
problem_statement_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Problem statement - App' table."];

// evaluators_table table
evaluators_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Evaluators table' table. A member who adds a record to the table becomes the 'owner' of that record."];

evaluators_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Evaluators table' table."];
evaluators_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Evaluators table' table."];
evaluators_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Evaluators table' table."];
evaluators_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Evaluators table' table."];

evaluators_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Evaluators table' table."];
evaluators_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Evaluators table' table."];
evaluators_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Evaluators table' table."];
evaluators_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Evaluators table' table, regardless of their owner."];

evaluators_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Evaluators table' table."];
evaluators_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Evaluators table' table."];
evaluators_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Evaluators table' table."];
evaluators_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Evaluators table' table."];

// approval_billing_table table
approval_billing_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Approval billing table' table. A member who adds a record to the table becomes the 'owner' of that record."];

approval_billing_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Approval billing table' table."];
approval_billing_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Approval billing table' table."];
approval_billing_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Approval billing table' table."];
approval_billing_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Approval billing table' table."];

approval_billing_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Approval billing table' table."];
approval_billing_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Approval billing table' table."];
approval_billing_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Approval billing table' table."];
approval_billing_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Approval billing table' table, regardless of their owner."];

approval_billing_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Approval billing table' table."];
approval_billing_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Approval billing table' table."];
approval_billing_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Approval billing table' table."];
approval_billing_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Approval billing table' table."];

// honorarium_claim_table table
honorarium_claim_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Honorarium - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

honorarium_claim_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Honorarium - App' table."];
honorarium_claim_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Honorarium - App' table."];
honorarium_claim_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Honorarium - App' table."];
honorarium_claim_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Honorarium - App' table."];

honorarium_claim_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Honorarium - App' table."];
honorarium_claim_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Honorarium - App' table."];
honorarium_claim_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Honorarium - App' table."];
honorarium_claim_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Honorarium - App' table, regardless of their owner."];

honorarium_claim_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Honorarium - App' table."];
honorarium_claim_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Honorarium - App' table."];
honorarium_claim_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Honorarium - App' table."];
honorarium_claim_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Honorarium - App' table."];

// honorarium_Activities table
honorarium_Activities_addTip=["",spacer+"This option allows all members of the group to add records to the 'Honorarium Activities' table. A member who adds a record to the table becomes the 'owner' of that record."];

honorarium_Activities_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Honorarium Activities' table."];
honorarium_Activities_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Honorarium Activities' table."];
honorarium_Activities_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Honorarium Activities' table."];
honorarium_Activities_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Honorarium Activities' table."];

honorarium_Activities_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Honorarium Activities' table."];
honorarium_Activities_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Honorarium Activities' table."];
honorarium_Activities_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Honorarium Activities' table."];
honorarium_Activities_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Honorarium Activities' table, regardless of their owner."];

honorarium_Activities_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Honorarium Activities' table."];
honorarium_Activities_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Honorarium Activities' table."];
honorarium_Activities_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Honorarium Activities' table."];
honorarium_Activities_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Honorarium Activities' table."];

// all_bank_account_statement_table table
all_bank_account_statement_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'All bank account statement - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

all_bank_account_statement_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'All bank account statement - App' table."];
all_bank_account_statement_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'All bank account statement - App' table."];
all_bank_account_statement_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'All bank account statement - App' table."];
all_bank_account_statement_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'All bank account statement - App' table."];

all_bank_account_statement_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'All bank account statement - App' table."];
all_bank_account_statement_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'All bank account statement - App' table."];
all_bank_account_statement_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'All bank account statement - App' table."];
all_bank_account_statement_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'All bank account statement - App' table, regardless of their owner."];

all_bank_account_statement_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'All bank account statement - App' table."];
all_bank_account_statement_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'All bank account statement - App' table."];
all_bank_account_statement_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'All bank account statement - App' table."];
all_bank_account_statement_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'All bank account statement - App' table."];

// payment_track_details_table table
payment_track_details_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Payment track details - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

payment_track_details_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Payment track details - App' table."];
payment_track_details_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Payment track details - App' table."];
payment_track_details_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Payment track details - App' table."];
payment_track_details_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Payment track details - App' table."];

payment_track_details_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Payment track details - App' table."];
payment_track_details_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Payment track details - App' table."];
payment_track_details_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Payment track details - App' table."];
payment_track_details_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Payment track details - App' table, regardless of their owner."];

payment_track_details_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Payment track details - App' table."];
payment_track_details_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Payment track details - App' table."];
payment_track_details_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Payment track details - App' table."];
payment_track_details_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Payment track details - App' table."];

// travel_table table
travel_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Travel - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

travel_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Travel - App' table."];
travel_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Travel - App' table."];
travel_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Travel - App' table."];
travel_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Travel - App' table."];

travel_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Travel - App' table."];
travel_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Travel - App' table."];
travel_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Travel - App' table."];
travel_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Travel - App' table, regardless of their owner."];

travel_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Travel - App' table."];
travel_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Travel - App' table."];
travel_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Travel - App' table."];
travel_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Travel - App' table."];

// travel_stay_table table
travel_stay_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Stay Details - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

travel_stay_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Stay Details - App' table."];
travel_stay_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Stay Details - App' table."];
travel_stay_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Stay Details - App' table."];
travel_stay_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Stay Details - App' table."];

travel_stay_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Stay Details - App' table."];
travel_stay_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Stay Details - App' table."];
travel_stay_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Stay Details - App' table."];
travel_stay_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Stay Details - App' table, regardless of their owner."];

travel_stay_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Stay Details - App' table."];
travel_stay_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Stay Details - App' table."];
travel_stay_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Stay Details - App' table."];
travel_stay_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Stay Details - App' table."];

// travel_local_commute_table table
travel_local_commute_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Local Commute - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

travel_local_commute_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Local Commute - App' table."];
travel_local_commute_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Local Commute - App' table."];
travel_local_commute_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Local Commute - App' table."];
travel_local_commute_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Local Commute - App' table."];

travel_local_commute_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Local Commute - App' table."];
travel_local_commute_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Local Commute - App' table."];
travel_local_commute_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Local Commute - App' table."];
travel_local_commute_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Local Commute - App' table, regardless of their owner."];

travel_local_commute_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Local Commute - App' table."];
travel_local_commute_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Local Commute - App' table."];
travel_local_commute_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Local Commute - App' table."];
travel_local_commute_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Local Commute - App' table."];

// r_and_d_progress table
r_and_d_progress_addTip=["",spacer+"This option allows all members of the group to add records to the 'Inhouse R & D App' table. A member who adds a record to the table becomes the 'owner' of that record."];

r_and_d_progress_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Inhouse R & D App' table."];
r_and_d_progress_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Inhouse R & D App' table."];
r_and_d_progress_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Inhouse R & D App' table."];
r_and_d_progress_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Inhouse R & D App' table."];

r_and_d_progress_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Inhouse R & D App' table."];
r_and_d_progress_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Inhouse R & D App' table."];
r_and_d_progress_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Inhouse R & D App' table."];
r_and_d_progress_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Inhouse R & D App' table, regardless of their owner."];

r_and_d_progress_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Inhouse R & D App' table."];
r_and_d_progress_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Inhouse R & D App' table."];
r_and_d_progress_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Inhouse R & D App' table."];
r_and_d_progress_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Inhouse R & D App' table."];

// panel_decision_table_tdp table
panel_decision_table_tdp_addTip=["",spacer+"This option allows all members of the group to add records to the 'TDP&#160;Projects&#160;- App' table. A member who adds a record to the table becomes the 'owner' of that record."];

panel_decision_table_tdp_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'TDP&#160;Projects&#160;- App' table."];
panel_decision_table_tdp_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'TDP&#160;Projects&#160;- App' table."];
panel_decision_table_tdp_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'TDP&#160;Projects&#160;- App' table."];
panel_decision_table_tdp_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'TDP&#160;Projects&#160;- App' table."];

panel_decision_table_tdp_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'TDP&#160;Projects&#160;- App' table."];
panel_decision_table_tdp_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'TDP&#160;Projects&#160;- App' table."];
panel_decision_table_tdp_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'TDP&#160;Projects&#160;- App' table."];
panel_decision_table_tdp_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'TDP&#160;Projects&#160;- App' table, regardless of their owner."];

panel_decision_table_tdp_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'TDP&#160;Projects&#160;- App' table."];
panel_decision_table_tdp_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'TDP&#160;Projects&#160;- App' table."];
panel_decision_table_tdp_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'TDP&#160;Projects&#160;- App' table."];
panel_decision_table_tdp_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'TDP&#160;Projects&#160;- App' table."];

// selected_proposals_final_tdp table
selected_proposals_final_tdp_addTip=["",spacer+"This option allows all members of the group to add records to the 'Selected proposals final - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

selected_proposals_final_tdp_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Selected proposals final - App' table."];
selected_proposals_final_tdp_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Selected proposals final - App' table."];
selected_proposals_final_tdp_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Selected proposals final - App' table."];
selected_proposals_final_tdp_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Selected proposals final - App' table."];

selected_proposals_final_tdp_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Selected proposals final - App' table."];
selected_proposals_final_tdp_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Selected proposals final - App' table."];
selected_proposals_final_tdp_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Selected proposals final - App' table."];
selected_proposals_final_tdp_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Selected proposals final - App' table, regardless of their owner."];

selected_proposals_final_tdp_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Selected proposals final - App' table."];
selected_proposals_final_tdp_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Selected proposals final - App' table."];
selected_proposals_final_tdp_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Selected proposals final - App' table."];
selected_proposals_final_tdp_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Selected proposals final - App' table."];

// stage_wise_budget_table_tdp table
stage_wise_budget_table_tdp_addTip=["",spacer+"This option allows all members of the group to add records to the 'Stage wise budget - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

stage_wise_budget_table_tdp_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Stage wise budget - App' table."];
stage_wise_budget_table_tdp_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Stage wise budget - App' table."];
stage_wise_budget_table_tdp_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Stage wise budget - App' table."];
stage_wise_budget_table_tdp_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Stage wise budget - App' table."];

stage_wise_budget_table_tdp_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Stage wise budget - App' table."];
stage_wise_budget_table_tdp_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Stage wise budget - App' table."];
stage_wise_budget_table_tdp_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Stage wise budget - App' table."];
stage_wise_budget_table_tdp_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Stage wise budget - App' table, regardless of their owner."];

stage_wise_budget_table_tdp_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Stage wise budget - App' table."];
stage_wise_budget_table_tdp_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Stage wise budget - App' table."];
stage_wise_budget_table_tdp_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Stage wise budget - App' table."];
stage_wise_budget_table_tdp_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Stage wise budget - App' table."];

// first_level_shortlisted_proposals_tdp table
first_level_shortlisted_proposals_tdp_addTip=["",spacer+"This option allows all members of the group to add records to the 'First level shortlisted proposals - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

first_level_shortlisted_proposals_tdp_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'First level shortlisted proposals - App' table."];
first_level_shortlisted_proposals_tdp_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'First level shortlisted proposals - App' table."];
first_level_shortlisted_proposals_tdp_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'First level shortlisted proposals - App' table."];
first_level_shortlisted_proposals_tdp_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'First level shortlisted proposals - App' table."];

first_level_shortlisted_proposals_tdp_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'First level shortlisted proposals - App' table."];
first_level_shortlisted_proposals_tdp_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'First level shortlisted proposals - App' table."];
first_level_shortlisted_proposals_tdp_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'First level shortlisted proposals - App' table."];
first_level_shortlisted_proposals_tdp_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'First level shortlisted proposals - App' table, regardless of their owner."];

first_level_shortlisted_proposals_tdp_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'First level shortlisted proposals - App' table."];
first_level_shortlisted_proposals_tdp_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'First level shortlisted proposals - App' table."];
first_level_shortlisted_proposals_tdp_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'First level shortlisted proposals - App' table."];
first_level_shortlisted_proposals_tdp_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'First level shortlisted proposals - App' table."];

// budget_table_tdp table
budget_table_tdp_addTip=["",spacer+"This option allows all members of the group to add records to the 'Budget App' table. A member who adds a record to the table becomes the 'owner' of that record."];

budget_table_tdp_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Budget App' table."];
budget_table_tdp_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Budget App' table."];
budget_table_tdp_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Budget App' table."];
budget_table_tdp_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Budget App' table."];

budget_table_tdp_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Budget App' table."];
budget_table_tdp_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Budget App' table."];
budget_table_tdp_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Budget App' table."];
budget_table_tdp_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Budget App' table, regardless of their owner."];

budget_table_tdp_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Budget App' table."];
budget_table_tdp_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Budget App' table."];
budget_table_tdp_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Budget App' table."];
budget_table_tdp_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Budget App' table."];

// panel_comments_tdp table
panel_comments_tdp_addTip=["",spacer+"This option allows all members of the group to add records to the 'Panel comments - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

panel_comments_tdp_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Panel comments - App' table."];
panel_comments_tdp_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Panel comments - App' table."];
panel_comments_tdp_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Panel comments - App' table."];
panel_comments_tdp_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Panel comments - App' table."];

panel_comments_tdp_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Panel comments - App' table."];
panel_comments_tdp_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Panel comments - App' table."];
panel_comments_tdp_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Panel comments - App' table."];
panel_comments_tdp_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Panel comments - App' table, regardless of their owner."];

panel_comments_tdp_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Panel comments - App' table."];
panel_comments_tdp_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Panel comments - App' table."];
panel_comments_tdp_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Panel comments - App' table."];
panel_comments_tdp_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Panel comments - App' table."];

// selected_tdp table
selected_tdp_addTip=["",spacer+"This option allows all members of the group to add records to the 'Selected (Draft) - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

selected_tdp_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Selected (Draft) - App' table."];
selected_tdp_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Selected (Draft) - App' table."];
selected_tdp_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Selected (Draft) - App' table."];
selected_tdp_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Selected (Draft) - App' table."];

selected_tdp_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Selected (Draft) - App' table."];
selected_tdp_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Selected (Draft) - App' table."];
selected_tdp_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Selected (Draft) - App' table."];
selected_tdp_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Selected (Draft) - App' table, regardless of their owner."];

selected_tdp_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Selected (Draft) - App' table."];
selected_tdp_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Selected (Draft) - App' table."];
selected_tdp_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Selected (Draft) - App' table."];
selected_tdp_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Selected (Draft) - App' table."];

// address_tdp table
address_tdp_addTip=["",spacer+"This option allows all members of the group to add records to the 'Address Details - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

address_tdp_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Address Details - App' table."];
address_tdp_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Address Details - App' table."];
address_tdp_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Address Details - App' table."];
address_tdp_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Address Details - App' table."];

address_tdp_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Address Details - App' table."];
address_tdp_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Address Details - App' table."];
address_tdp_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Address Details - App' table."];
address_tdp_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Address Details - App' table, regardless of their owner."];

address_tdp_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Address Details - App' table."];
address_tdp_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Address Details - App' table."];
address_tdp_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Address Details - App' table."];
address_tdp_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Address Details - App' table."];

// summary_table_tdp table
summary_table_tdp_addTip=["",spacer+"This option allows all members of the group to add records to the 'Summary of TDP - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

summary_table_tdp_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Summary of TDP - App' table."];
summary_table_tdp_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Summary of TDP - App' table."];
summary_table_tdp_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Summary of TDP - App' table."];
summary_table_tdp_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Summary of TDP - App' table."];

summary_table_tdp_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Summary of TDP - App' table."];
summary_table_tdp_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Summary of TDP - App' table."];
summary_table_tdp_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Summary of TDP - App' table."];
summary_table_tdp_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Summary of TDP - App' table, regardless of their owner."];

summary_table_tdp_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Summary of TDP - App' table."];
summary_table_tdp_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Summary of TDP - App' table."];
summary_table_tdp_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Summary of TDP - App' table."];
summary_table_tdp_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Summary of TDP - App' table."];

// project_details_tdp table
project_details_tdp_addTip=["",spacer+"This option allows all members of the group to add records to the 'Project details - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

project_details_tdp_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Project details - App' table."];
project_details_tdp_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Project details - App' table."];
project_details_tdp_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Project details - App' table."];
project_details_tdp_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Project details - App' table."];

project_details_tdp_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Project details - App' table."];
project_details_tdp_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Project details - App' table."];
project_details_tdp_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Project details - App' table."];
project_details_tdp_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Project details - App' table, regardless of their owner."];

project_details_tdp_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Project details - App' table."];
project_details_tdp_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Project details - App' table."];
project_details_tdp_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Project details - App' table."];
project_details_tdp_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Project details - App' table."];

// newsletter_table table
newsletter_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Newsletter - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

newsletter_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Newsletter - App' table."];
newsletter_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Newsletter - App' table."];
newsletter_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Newsletter - App' table."];
newsletter_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Newsletter - App' table."];

newsletter_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Newsletter - App' table."];
newsletter_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Newsletter - App' table."];
newsletter_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Newsletter - App' table."];
newsletter_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Newsletter - App' table, regardless of their owner."];

newsletter_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Newsletter - App' table."];
newsletter_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Newsletter - App' table."];
newsletter_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Newsletter - App' table."];
newsletter_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Newsletter - App' table."];

// contact_call_log_table table
contact_call_log_table_addTip=["",spacer+"This option allows all members of the group to add records to the 'Contact Call Log - App' table. A member who adds a record to the table becomes the 'owner' of that record."];

contact_call_log_table_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Contact Call Log - App' table."];
contact_call_log_table_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Contact Call Log - App' table."];
contact_call_log_table_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Contact Call Log - App' table."];
contact_call_log_table_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Contact Call Log - App' table."];

contact_call_log_table_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Contact Call Log - App' table."];
contact_call_log_table_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Contact Call Log - App' table."];
contact_call_log_table_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Contact Call Log - App' table."];
contact_call_log_table_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Contact Call Log - App' table, regardless of their owner."];

contact_call_log_table_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Contact Call Log - App' table."];
contact_call_log_table_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Contact Call Log - App' table."];
contact_call_log_table_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Contact Call Log - App' table."];
contact_call_log_table_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Contact Call Log - App' table."];

// r_and_d_monthly_progress_app table
r_and_d_monthly_progress_app_addTip=["",spacer+"This option allows all members of the group to add records to the 'Monthly Progress App' table. A member who adds a record to the table becomes the 'owner' of that record."];

r_and_d_monthly_progress_app_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Monthly Progress App' table."];
r_and_d_monthly_progress_app_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Monthly Progress App' table."];
r_and_d_monthly_progress_app_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Monthly Progress App' table."];
r_and_d_monthly_progress_app_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Monthly Progress App' table."];

r_and_d_monthly_progress_app_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Monthly Progress App' table."];
r_and_d_monthly_progress_app_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Monthly Progress App' table."];
r_and_d_monthly_progress_app_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Monthly Progress App' table."];
r_and_d_monthly_progress_app_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Monthly Progress App' table, regardless of their owner."];

r_and_d_monthly_progress_app_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Monthly Progress App' table."];
r_and_d_monthly_progress_app_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Monthly Progress App' table."];
r_and_d_monthly_progress_app_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Monthly Progress App' table."];
r_and_d_monthly_progress_app_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Monthly Progress App' table."];

// r_and_d_quarterly_progress_app table
r_and_d_quarterly_progress_app_addTip=["",spacer+"This option allows all members of the group to add records to the 'Quarterly Progress App' table. A member who adds a record to the table becomes the 'owner' of that record."];

r_and_d_quarterly_progress_app_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Quarterly Progress App' table."];
r_and_d_quarterly_progress_app_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Quarterly Progress App' table."];
r_and_d_quarterly_progress_app_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Quarterly Progress App' table."];
r_and_d_quarterly_progress_app_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Quarterly Progress App' table."];

r_and_d_quarterly_progress_app_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Quarterly Progress App' table."];
r_and_d_quarterly_progress_app_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Quarterly Progress App' table."];
r_and_d_quarterly_progress_app_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Quarterly Progress App' table."];
r_and_d_quarterly_progress_app_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Quarterly Progress App' table, regardless of their owner."];

r_and_d_quarterly_progress_app_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Quarterly Progress App' table."];
r_and_d_quarterly_progress_app_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Quarterly Progress App' table."];
r_and_d_quarterly_progress_app_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Quarterly Progress App' table."];
r_and_d_quarterly_progress_app_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Quarterly Progress App' table."];

// projects table
projects_addTip=["",spacer+"This option allows all members of the group to add records to the 'Projects' table. A member who adds a record to the table becomes the 'owner' of that record."];

projects_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Projects' table."];
projects_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Projects' table."];
projects_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Projects' table."];
projects_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Projects' table."];

projects_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Projects' table."];
projects_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Projects' table."];
projects_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Projects' table."];
projects_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Projects' table, regardless of their owner."];

projects_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Projects' table."];
projects_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Projects' table."];
projects_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Projects' table."];
projects_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Projects' table."];

// td_projects_td_intellectual_property table
td_projects_td_intellectual_property_addTip=["",spacer+"This option allows all members of the group to add records to the 'Intellectual Property' table. A member who adds a record to the table becomes the 'owner' of that record."];

td_projects_td_intellectual_property_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Intellectual Property' table."];
td_projects_td_intellectual_property_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Intellectual Property' table."];
td_projects_td_intellectual_property_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Intellectual Property' table."];
td_projects_td_intellectual_property_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Intellectual Property' table."];

td_projects_td_intellectual_property_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Intellectual Property' table."];
td_projects_td_intellectual_property_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Intellectual Property' table."];
td_projects_td_intellectual_property_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Intellectual Property' table."];
td_projects_td_intellectual_property_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Intellectual Property' table, regardless of their owner."];

td_projects_td_intellectual_property_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Intellectual Property' table."];
td_projects_td_intellectual_property_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Intellectual Property' table."];
td_projects_td_intellectual_property_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Intellectual Property' table."];
td_projects_td_intellectual_property_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Intellectual Property' table."];

// td_projects_td_technology_products table
td_projects_td_technology_products_addTip=["",spacer+"This option allows all members of the group to add records to the 'Technology Products' table. A member who adds a record to the table becomes the 'owner' of that record."];

td_projects_td_technology_products_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Technology Products' table."];
td_projects_td_technology_products_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Technology Products' table."];
td_projects_td_technology_products_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Technology Products' table."];
td_projects_td_technology_products_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Technology Products' table."];

td_projects_td_technology_products_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Technology Products' table."];
td_projects_td_technology_products_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Technology Products' table."];
td_projects_td_technology_products_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Technology Products' table."];
td_projects_td_technology_products_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Technology Products' table, regardless of their owner."];

td_projects_td_technology_products_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Technology Products' table."];
td_projects_td_technology_products_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Technology Products' table."];
td_projects_td_technology_products_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Technology Products' table."];
td_projects_td_technology_products_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Technology Products' table."];

// td_publications_and_intellectual_activities table
td_publications_and_intellectual_activities_addTip=["",spacer+"This option allows all members of the group to add records to the 'Publications and Intellectual Activities' table. A member who adds a record to the table becomes the 'owner' of that record."];

td_publications_and_intellectual_activities_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Publications and Intellectual Activities' table."];
td_publications_and_intellectual_activities_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Publications and Intellectual Activities' table."];
td_publications_and_intellectual_activities_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Publications and Intellectual Activities' table."];
td_publications_and_intellectual_activities_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Publications and Intellectual Activities' table."];

td_publications_and_intellectual_activities_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Publications and Intellectual Activities' table."];
td_publications_and_intellectual_activities_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Publications and Intellectual Activities' table."];
td_publications_and_intellectual_activities_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Publications and Intellectual Activities' table."];
td_publications_and_intellectual_activities_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Publications and Intellectual Activities' table, regardless of their owner."];

td_publications_and_intellectual_activities_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Publications and Intellectual Activities' table."];
td_publications_and_intellectual_activities_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Publications and Intellectual Activities' table."];
td_publications_and_intellectual_activities_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Publications and Intellectual Activities' table."];
td_publications_and_intellectual_activities_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Publications and Intellectual Activities' table."];

// td_publications table
td_publications_addTip=["",spacer+"This option allows all members of the group to add records to the 'Td publications' table. A member who adds a record to the table becomes the 'owner' of that record."];

td_publications_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Td publications' table."];
td_publications_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Td publications' table."];
td_publications_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Td publications' table."];
td_publications_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Td publications' table."];

td_publications_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Td publications' table."];
td_publications_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Td publications' table."];
td_publications_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Td publications' table."];
td_publications_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Td publications' table, regardless of their owner."];

td_publications_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Td publications' table."];
td_publications_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Td publications' table."];
td_publications_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Td publications' table."];
td_publications_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Td publications' table."];

// td_ipr table
td_ipr_addTip=["",spacer+"This option allows all members of the group to add records to the 'IPR' table. A member who adds a record to the table becomes the 'owner' of that record."];

td_ipr_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'IPR' table."];
td_ipr_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'IPR' table."];
td_ipr_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'IPR' table."];
td_ipr_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'IPR' table."];

td_ipr_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'IPR' table."];
td_ipr_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'IPR' table."];
td_ipr_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'IPR' table."];
td_ipr_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'IPR' table, regardless of their owner."];

td_ipr_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'IPR' table."];
td_ipr_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'IPR' table."];
td_ipr_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'IPR' table."];
td_ipr_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'IPR' table."];

// td_cps_research_base table
td_cps_research_base_addTip=["",spacer+"This option allows all members of the group to add records to the 'CPS Research Base' table. A member who adds a record to the table becomes the 'owner' of that record."];

td_cps_research_base_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'CPS Research Base' table."];
td_cps_research_base_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'CPS Research Base' table."];
td_cps_research_base_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'CPS Research Base' table."];
td_cps_research_base_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'CPS Research Base' table."];

td_cps_research_base_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'CPS Research Base' table."];
td_cps_research_base_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'CPS Research Base' table."];
td_cps_research_base_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'CPS Research Base' table."];
td_cps_research_base_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'CPS Research Base' table, regardless of their owner."];

td_cps_research_base_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'CPS Research Base' table."];
td_cps_research_base_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'CPS Research Base' table."];
td_cps_research_base_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'CPS Research Base' table."];
td_cps_research_base_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'CPS Research Base' table."];

// ed_tbi table
ed_tbi_addTip=["",spacer+"This option allows all members of the group to add records to the 'Technology Business Incubator (TBI)' table. A member who adds a record to the table becomes the 'owner' of that record."];

ed_tbi_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Technology Business Incubator (TBI)' table."];
ed_tbi_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Technology Business Incubator (TBI)' table."];
ed_tbi_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Technology Business Incubator (TBI)' table."];
ed_tbi_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Technology Business Incubator (TBI)' table."];

ed_tbi_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Technology Business Incubator (TBI)' table."];
ed_tbi_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Technology Business Incubator (TBI)' table."];
ed_tbi_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Technology Business Incubator (TBI)' table."];
ed_tbi_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Technology Business Incubator (TBI)' table, regardless of their owner."];

ed_tbi_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Technology Business Incubator (TBI)' table."];
ed_tbi_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Technology Business Incubator (TBI)' table."];
ed_tbi_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Technology Business Incubator (TBI)' table."];
ed_tbi_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Technology Business Incubator (TBI)' table."];

// ed_startup_companies table
ed_startup_companies_addTip=["",spacer+"This option allows all members of the group to add records to the 'Start-ups & Spin-off companies' table. A member who adds a record to the table becomes the 'owner' of that record."];

ed_startup_companies_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Start-ups & Spin-off companies' table."];
ed_startup_companies_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Start-ups & Spin-off companies' table."];
ed_startup_companies_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Start-ups & Spin-off companies' table."];
ed_startup_companies_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Start-ups & Spin-off companies' table."];

ed_startup_companies_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Start-ups & Spin-off companies' table."];
ed_startup_companies_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Start-ups & Spin-off companies' table."];
ed_startup_companies_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Start-ups & Spin-off companies' table."];
ed_startup_companies_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Start-ups & Spin-off companies' table, regardless of their owner."];

ed_startup_companies_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Start-ups & Spin-off companies' table."];
ed_startup_companies_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Start-ups & Spin-off companies' table."];
ed_startup_companies_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Start-ups & Spin-off companies' table."];
ed_startup_companies_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Start-ups & Spin-off companies' table."];

// ed_gcc table
ed_gcc_addTip=["",spacer+"This option allows all members of the group to add records to the 'GCC - Grand Challenges & Competitions' table. A member who adds a record to the table becomes the 'owner' of that record."];

ed_gcc_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'GCC - Grand Challenges & Competitions' table."];
ed_gcc_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'GCC - Grand Challenges & Competitions' table."];
ed_gcc_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'GCC - Grand Challenges & Competitions' table."];
ed_gcc_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'GCC - Grand Challenges & Competitions' table."];

ed_gcc_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'GCC - Grand Challenges & Competitions' table."];
ed_gcc_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'GCC - Grand Challenges & Competitions' table."];
ed_gcc_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'GCC - Grand Challenges & Competitions' table."];
ed_gcc_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'GCC - Grand Challenges & Competitions' table, regardless of their owner."];

ed_gcc_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'GCC - Grand Challenges & Competitions' table."];
ed_gcc_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'GCC - Grand Challenges & Competitions' table."];
ed_gcc_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'GCC - Grand Challenges & Competitions' table."];
ed_gcc_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'GCC - Grand Challenges & Competitions' table."];

// ed_eir table
ed_eir_addTip=["",spacer+"This option allows all members of the group to add records to the 'Entrepreneur In Residence (EIR)' table. A member who adds a record to the table becomes the 'owner' of that record."];

ed_eir_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Entrepreneur In Residence (EIR)' table."];
ed_eir_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Entrepreneur In Residence (EIR)' table."];
ed_eir_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Entrepreneur In Residence (EIR)' table."];
ed_eir_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Entrepreneur In Residence (EIR)' table."];

ed_eir_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Entrepreneur In Residence (EIR)' table."];
ed_eir_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Entrepreneur In Residence (EIR)' table."];
ed_eir_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Entrepreneur In Residence (EIR)' table."];
ed_eir_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Entrepreneur In Residence (EIR)' table, regardless of their owner."];

ed_eir_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Entrepreneur In Residence (EIR)' table."];
ed_eir_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Entrepreneur In Residence (EIR)' table."];
ed_eir_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Entrepreneur In Residence (EIR)' table."];
ed_eir_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Entrepreneur In Residence (EIR)' table."];

// ed_job_creation table
ed_job_creation_addTip=["",spacer+"This option allows all members of the group to add records to the 'Job Creation' table. A member who adds a record to the table becomes the 'owner' of that record."];

ed_job_creation_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Job Creation' table."];
ed_job_creation_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Job Creation' table."];
ed_job_creation_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Job Creation' table."];
ed_job_creation_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Job Creation' table."];

ed_job_creation_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Job Creation' table."];
ed_job_creation_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Job Creation' table."];
ed_job_creation_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Job Creation' table."];
ed_job_creation_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Job Creation' table, regardless of their owner."];

ed_job_creation_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Job Creation' table."];
ed_job_creation_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Job Creation' table."];
ed_job_creation_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Job Creation' table."];
ed_job_creation_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Job Creation' table."];

// hrd_Fellowship table
hrd_Fellowship_addTip=["",spacer+"This option allows all members of the group to add records to the 'Fellowship' table. A member who adds a record to the table becomes the 'owner' of that record."];

hrd_Fellowship_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Fellowship' table."];
hrd_Fellowship_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Fellowship' table."];
hrd_Fellowship_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Fellowship' table."];
hrd_Fellowship_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Fellowship' table."];

hrd_Fellowship_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Fellowship' table."];
hrd_Fellowship_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Fellowship' table."];
hrd_Fellowship_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Fellowship' table."];
hrd_Fellowship_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Fellowship' table, regardless of their owner."];

hrd_Fellowship_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Fellowship' table."];
hrd_Fellowship_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Fellowship' table."];
hrd_Fellowship_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Fellowship' table."];
hrd_Fellowship_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Fellowship' table."];

// hrd_sd table
hrd_sd_addTip=["",spacer+"This option allows all members of the group to add records to the 'Skill Development' table. A member who adds a record to the table becomes the 'owner' of that record."];

hrd_sd_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Skill Development' table."];
hrd_sd_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Skill Development' table."];
hrd_sd_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Skill Development' table."];
hrd_sd_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Skill Development' table."];

hrd_sd_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Skill Development' table."];
hrd_sd_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Skill Development' table."];
hrd_sd_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Skill Development' table."];
hrd_sd_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Skill Development' table, regardless of their owner."];

hrd_sd_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Skill Development' table."];
hrd_sd_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Skill Development' table."];
hrd_sd_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Skill Development' table."];
hrd_sd_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Skill Development' table."];

// it_International_Collaboration table
it_International_Collaboration_addTip=["",spacer+"This option allows all members of the group to add records to the 'International Collaboration' table. A member who adds a record to the table becomes the 'owner' of that record."];

it_International_Collaboration_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'International Collaboration' table."];
it_International_Collaboration_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'International Collaboration' table."];
it_International_Collaboration_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'International Collaboration' table."];
it_International_Collaboration_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'International Collaboration' table."];

it_International_Collaboration_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'International Collaboration' table."];
it_International_Collaboration_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'International Collaboration' table."];
it_International_Collaboration_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'International Collaboration' table."];
it_International_Collaboration_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'International Collaboration' table, regardless of their owner."];

it_International_Collaboration_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'International Collaboration' table."];
it_International_Collaboration_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'International Collaboration' table."];
it_International_Collaboration_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'International Collaboration' table."];
it_International_Collaboration_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'International Collaboration' table."];

/*
	Style syntax:
	-------------
	[TitleColor,TextColor,TitleBgColor,TextBgColor,TitleBgImag,TextBgImag,TitleTextAlign,
	TextTextAlign,TitleFontFace,TextFontFace, TipPosition, StickyStyle, TitleFontSize,
	TextFontSize, Width, Height, BorderSize, PadTextArea, CoordinateX , CoordinateY,
	TransitionNumber, TransitionDuration, TransparencyLevel ,ShadowType, ShadowColor]

*/

toolTipStyle=["white","#00008B","#000099","#E6E6FA","","images/helpBg.gif","","","","\"Trebuchet MS\", sans-serif","","","","3",400,"",1,2,10,10,51,1,0,"",""];

applyCssFilter();
