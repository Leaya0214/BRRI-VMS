<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <tr>
                <th class="bg-info text-center" colspan="3">
                     All Information
                </th>
            </tr>
            <tr>
                <th> Image</th>
                <th>:</th>
                <th><img src="{{ $employee->image ? asset('employee/'.$employee->image) : asset('image/admin_layout/avatar5.png') }}"  width="100px"/></th>
            </tr>
            <tr>
                <th>Name</th>
                <th>:</th>
                <th>{{ $employee->name }}</th>
            </tr>
            <tr>
                <th>Office ID</th>
                <th>:</th>
                <th>{{ $employee->office_id }}</th>
            </tr>
            <tr>
                <th>NID/Smart ID</th>
                <th>:</th>
                <th>{{ $employee->nid }}</th>
            </tr>
            <tr>
                <th>Blood Group</th>
                <th>:</th>
                <th>{{ $employee->blood_group }}</th>
            </tr>

            <tr>
                <th>Division</th>
                <th>:</th>
                <th>
                    @if ($employee->section != null)
                        {{ $employee->section->section_name }}
                    @endif
                </th>
            </tr>
            <tr>
                <th>Designation</th>
                <th>:</th>
                <th>
                    @if ($employee->designation != null)
                        {{ $employee->designation->name }}
                    @endif
                </th>
            </tr>
            <tr>
                <th>Mobile</th>
                <th>:</th>
                <th>
                    @if ($employee->mobile_no != null)
                        {{ $employee->mobile_no }}
                    @endif
                </th>
            </tr>
            <tr>
                <th>Email</th>
                <th>:</th>
                <th>
                    @if ($employee->email != null)
                        {{ $employee->email }}
                    @endif
                </th>
            </tr>

            <tr>
                <th>Joining Date</th>
                <th>:</th>
                <th>{{ date('d/m/Y', strtotime($employee->joining_date)) }}</th>
            </tr>

            <tr>
                <th>PRL Date</th>
                <th>:</th>
                <th>{{ date('d/m/Y', strtotime($employee->prl_date)) }}</th>
            </tr>

            <tr>
                <th> Role</th>
                <th>:</th>
                <th>{{$employee->role??''}}</th>
            </tr>
            <tr>
                <th> Signature</th>
                <th>:</th>
                <th><img src="{{ $employee->signature ? asset('employee/'.$employee->signature) :'' }}"  width="100px"/></th>
            </tr>

        </table>
    </div>


</div>
