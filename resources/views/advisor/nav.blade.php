<nav class="navbar navbar-inverse navbar-embossed" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
            <span class="sr-only">Toggle navigation</span>
        </button>
        <a class="navbar-brand" href="#">AirVia</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse-01">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/{{auth()->user()->role}}/home">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sales & Refunds <b class="caret"></b></a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="/advisor/sales/create">Record Sale</a></li>
                        <li><a href="/advisor/refunds/create">Record Refund</a></li>
                        <li class="divider"></li>
                        <li><a href="/advisor/sales">View Sales</a></li>
                        <li><a href="/advisor/refunds">View Refunds</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Customers<b class="caret"></b></a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="/advisor/customers/create">Create New Account</a></li>
                        <li class="divider"></li>
                        <li><a href="/advisor/customers">View Accounts</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<b class="caret"></b></a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="/advisor/reports/create">Generate Personal Sales</a></li>
                        <li class="divider"></li>
                        <li><a href="/advisor/reports">View Personal Sales</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="navbar-text" class="dropdown-toggle" data-toggle="dropdown">Signed in as {{auth()->user()->name}}  <b class="caret"></b> </a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="/logout">Log out</a></li>
                    </ul>
                </li>
            </ul>
    </div><!-- /.navbar-collapse -->
</nav>