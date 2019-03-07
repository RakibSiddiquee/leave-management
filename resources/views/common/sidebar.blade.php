  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="active treeview">
          <a href="{{ url('/backend/dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Leave Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('backend/bn-contents/create') }}"><i class="fa fa-plus-square"></i> Request Leave</a></li>
            <li><a href="{{ url('backend/bn-contents') }}"><i class="fa fa-file-o"></i> Leave list</a></li>
          </ul>
        </li>
        @if(auth('web')->check())

          <li><a href="{{ route('admin.employees.index') }}"><i class="fa fa-file-o"></i> Employee Management</a></li>
          <li><a href="{{ route('admin.designations.index') }}"><i class="fa fa-plus-square"></i> Designation</a></li>
          <li><a href="{{ route('admin.departments.index') }}"><i class="fa fa-file-o"></i> Department</a></li>
          <li><a href="{{ route('admin.admins.index') }}"><i class="fa fa-file-o"></i> Admin</a></li>

        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>