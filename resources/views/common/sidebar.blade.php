  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        @if(auth('web')->check())
          <li class="active treeview">
            <a href="{{ route('admin.dashboard') }}">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>
        @endif

        <li><a href="{{ auth('employee')->check() ? route('employee.leaves.index') : route('admin.leaves.index') }}"><i class="fa fa-file-o"></i> Leave</a></li>
        @if(auth('web')->check())
          <li><a href="{{ route('admin.report') }}"><i class="fa fa-file-o"></i> Report</a></li>
          <li><a href="{{ route('admin.employees.index') }}"><i class="fa fa-file-o"></i> Employee</a></li>
          <li><a href="{{ route('admin.designations.index') }}"><i class="fa fa-plus-square"></i> Designation</a></li>
          <li><a href="{{ route('admin.departments.index') }}"><i class="fa fa-file-o"></i> Department</a></li>
          <li><a href="{{ route('admin.leave-types.index') }}"><i class="fa fa-file-o"></i> Leave Type</a></li>
          <li><a href="{{ route('admin.admins.index') }}"><i class="fa fa-file-o"></i> Admin</a></li>

        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>