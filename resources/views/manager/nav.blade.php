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


                <!-- Blanks -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Blanks<b class="caret"></b></a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="/manager/blanktypes">View Blank Types</a></li>
                        <li><a href="/manager/blanks">View Blanks</a></li>
                    </ul>
                </li>


                <!-- Customers -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Customers <b class="caret"></b></a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="/manager/customers/create">Create Accounts</a></li>
                        <li class="divider"></li>
                        <li><a href="/manager/customers">View Accounts</a></li>
                        <li><a href="/manager/discounts/">View Discount Bands</a></li>
                    </ul>
                </li>

                <!-- Currency -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Currency<b class="caret"></b></a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="/manager/currencies/index">View Currency</a></li>
                    </ul>
                </li>

                <!-- Reports -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<b class="caret"></b></a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="/manager/reports/individual-sales/create">Individual</a></li>
                        <li><a href="/manager/reports/global-sales/create">Global</a></li>
                        <li><a href="/manager/reports/ticket-stock-turnover/create">Ticket Stock Turnover</a></li>
                        <li><a href="#">Customer</a></li>
                    </ul>
                </li>


                <!-- Sales & Refunds -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sales & Refunds <b class="caret"></b></a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="/manager/sales/create">Record Sale</a></li>
                        <li><a href="/manager/refunds/create">Record Refund</a></li>
                        <li class="divider"></li>
                        <li><a href="/manager/sales/">View Sales</a></li>
                        <li><a href="/manager/refunds/">View Refunds</a></li>
                    </ul>
                </li>

                <!-- Refunds -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Refunds<b class="caret"></b></a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="/manager/refunds/create">Record Refunds</a></li>
                        <li class="divider"></li>
                        <li><a href="/manager/refunds">View Refunds</a></li>
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