{{-- <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" {{(is_numeric(array_search('hrm', array_column($menu_permission, 'menu_slug'))))?"checked=''":""}} class="custom-control-input" value="hrm" name="menu[]" id="customSwitch1" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch1">HRM</label>
</div>
<div class="row">
    <div class="col-12 pl-5">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('report', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}}  value="hrm|department-list" name="sub_menu[]">
            <label >Department</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input  type="checkbox"  value="hrm|branch-list" {{(array_search('report', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}}  name="sub_menu[]">
            <label>Branch Office</label>
        </div>
        
        <div class="custom-control custom-checkbox">
            <input  type="checkbox" {{(array_search('section-list', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}}  value="hrm|section-list" name="sub_menu[]">
            <label>Section</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input  type="checkbox" {{(array_search('designation-list', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}}  value="hrm|designation-list" name="sub_menu[]">
            <label>Designation</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('grade-list', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}}  value="hrm|grade-list" name="sub_menu[]">
            <label>Grade</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('paymentType-list', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|paymentType-list" name="sub_menu[]">
            <label>Payment Type</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('schedule-list', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|schedule-list" name="sub_menu[]">
            <label>Schedule</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('employee-create', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|employee-create" name="sub_menu[]">
            <label>Employee Create</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('manage-employee', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|manage-employee" name="sub_menu[]">
            <label>Manage Employee</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('employee-performance', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|employee-performance" name="sub_menu[]">
            <label>Employee Performance</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('attendance-entry', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|attendance-entry" name="sub_menu[]">
            <label >Attendance Entry</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('attendance-list', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|attendance-list" name="sub_menu[]">
            <label >Attendance List</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('attendance-monthly-report', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|attendance-monthly-report" name="sub_menu[]">
            <label >Monthly Attendance Report</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('job-card', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|job-card" name="sub_menu[]">
            <label >Job Card Details</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('holiday', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|holiday" name="sub_menu[]">
            <label >Holiday</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('leave-type-list', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|leave-type-list" name="sub_menu[]">
            <label >Leave Type</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('leave', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|leave" name="sub_menu[]">
            <label >Leave Entry</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('leave-report', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|leave-report" name="sub_menu[]">
            <label >Leave Report</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('employee-salary', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|employee-salary" name="sub_menu[]">
            <label >Salary Generate</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('employee-salary-list', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="hrm|employee-salary-list" name="sub_menu[]">
            <label >Salary Report</label>
        </div>
    </div>
</div> --}}

{{-- @dd($menu_permission) --}}

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('income', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}}  value="income" name="menu[]" id="income" style="cursor: pointer !important">
    <label class="custom-control-label" for="income">Income</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input"  {{((array_search('expense', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="expense" name="menu[]" id="expense" style="cursor: pointer !important">
    <label class="custom-control-label" for="expense">Expense</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('accounts', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="accounts" name="menu[]" id="customSwitch2" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch2">Accounts</label>
</div>
<div class="row">
    <div class="col-12 pl-5">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('report', array_column($sub_menu_permission, 'menu_slug'))) !== false ?"checked=''":""}}  value="accounts|report" class="submenu-2" name="sub_menu[]">
            <label >Report</label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('account-main-head', array_column($sub_menu_permission, 'menu_slug')))!== false?"checked=''":""}} value="accounts|account-main-head" class="submenu-2" name="sub_menu[]">
            <label >Account Main Head</label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('account-sub-head', array_column($sub_menu_permission, 'menu_slug')))!== false?"checked=''":""}} value="accounts|account-sub-head" class="submenu-2" name="sub_menu[]">
            <label>Account Sub Head</label>
        </div>
{{-- 
        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('deposit', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="accounts|deposit" name="sub_menu[]">
            <label >Deposit</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('bank-granty', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="accounts|bank-granty" name="sub_menu[]">
            <label >Bank Granty</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('pg-amount', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="accounts|pg-amount" name="sub_menu[]">
            <label >PG Amount</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('fdr-amount', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="accounts|fdr-amount" name="sub_menu[]">
            <label >FDR Amount</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('security-money', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="accounts|security-money" name="sub_menu[]">
            <label >Security Money</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('loan-status', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="accounts|loan-status" name="sub_menu[]">
            <label >Loan Status</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('expense', array_column($sub_menu_permission, 'menu_slug')))?"checked=''":""}} value="accounts|expense" name="sub_menu[]">
            <label >Expense</label>
        </div> --}}
    </div>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('fund_transfer', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="fund_transfer" name="menu[]" id="fund_transfer" style="cursor: pointer !important">
    <label class="custom-control-label" for="fund_transfer">Fund Transfer</label>
</div>
<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('bank_info', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}}  value="bank_info" name="menu[]" id="bank_info" style="cursor: pointer !important">
    <label class="custom-control-label" for="bank_info">Bank Inforamtion</label>
</div>
<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('fund', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="fund" name="menu[]" id="fund" style="cursor: pointer !important">
    <label class="custom-control-label" for="fund">Fund Management</label>
</div>
<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('project', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="project" name="menu[]" id="project" style="cursor: pointer !important">
    <label class="custom-control-label" for="project">Project</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('capital', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="capital" name="menu[]" id="capital" style="cursor: pointer !important">
    <label class="custom-control-label" for="capital">Capital</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('loan', array_column($menu_permission, 'menu_slug'))) !== false)?"checked=''":""}} value="loan" name="menu[]" id="loan" style="cursor: pointer !important">
    <label class="custom-control-label" for="loan">Loan</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('investment', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="investment" name="menu[]" id="investment" style="cursor: pointer !important">
    <label class="custom-control-label" for="investment">Investment</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('asset-management', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="asset-management" name="menu[]" id="asset-management" style="cursor: pointer !important">
    <label class="custom-control-label" for="asset-management">Asset Management</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('sales', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="sales" name="menu[]" id="customSwitch3" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch3">Land Sales</label>
</div>

{{-- <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('work-status', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="work-status" name="menu[]" id="customSwitch4" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch4"> Works & Man Power</label>
</div> --}}

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('requisition', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="requisition" name="menu[]" id="customSwitch5" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch5">Requisition</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('purchase', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="purchase" name="menu[]" id="customSwitch6" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch6">Purchase</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('inventory', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="inventory" name="menu[]" id="customSwitch7" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch7">Inventroy</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('supplier', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="supplier" name="menu[]" id="customSwitch8" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch8">Supplier</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('vendor', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="vendor" name="menu[]" id="customSwitch9" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch9">Vendor / Sub Contractor</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('project', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="project" name="menu[]" id="customSwitch10" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch10">Project Status</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('audit-list', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="audit-list" name="menu[]" id="customSwitch11" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch11">Audit Report</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('bill-list', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="bill-list" name="menu[]" id="customSwitch12" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch12">Bill</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('licenses-list', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="licenses-list" name="menu[]" id="customSwitch13" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch13">Licenses Status</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('basic_settings', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="basic_settings" name="menu[]" id="customSwitch14" style="cursor: pointer !important">
    <label class="custom-control-label" for="customSwitch14">Basic Settings</label>
</div>

<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" class="custom-control-input" {{((array_search('site-manager', array_column($menu_permission, 'menu_slug')))!== false)?"checked=''":""}} value="site-manager" name="menu[]" id="site-manager" style="cursor: pointer !important">
    <label class="custom-control-label" for="site-manager">Site Manager Access</label>
</div>
<div class="row">
    <div class="col-12 pl-5">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('expenses', array_column($sub_menu_permission, 'menu_slug')))!== false?"checked=''":""}} value="site-manager|expenses" class="submenu-3" name="sub_menu[]">
            <label>Site Expneses</label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('financial-requisition', array_column($sub_menu_permission, 'menu_slug')))!== false?"checked=''":""}} value="site-manager|financial-requisition" class="submenu-3" name="sub_menu[]">
            <label>Financial Requisition</label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" {{(array_search('material-requisition', array_column($sub_menu_permission, 'menu_slug')))!== false?"checked=''":""}} value="site-manager|material-requisition" class="submenu-3" name="sub_menu[]">
            <label>Material Requisition</label>
        </div>

    </div>
</div>

<script>
        $('#customSwitch2').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.submenu-2:checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
            $('.submenu-2:checkbox').each(function() {
                this.checked = false;                       
            });
        }
    });

    $('#site-manager').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.submenu-3:checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
            $('.submenu-3:checkbox').each(function() {
                this.checked = false;                       
            });
        }
    });
</script>