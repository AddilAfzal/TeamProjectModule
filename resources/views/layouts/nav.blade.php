<nav class="navbar navbar-inverse navbar-embossed" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
            <span class="sr-only">Toggle navigation</span>
        </button>
        <a class="navbar-brand" href="#">AirVia</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse-01">

        @if(auth()->check() == true)
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/{{auth()->user()->role}}/home">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sales & Refunds <b class="caret"></b></a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="#">Record Sale</a></li>
                        <li><a href="#">Record Refund</a></li>
                        <li class="divider"></li>
                        <li><a href="#">View Sales</a></li>
                        <li><a href="#">View Refunds</a></li>
                    </ul>
                </li>
                <li><a href="#fakelink">Customers</a></li>
                <li><a href="#fakelink">Reports</a></li>


                <li class="dropdown">
                    <a class="navbar-text" class="dropdown-toggle" data-toggle="dropdown">Signed in as {{auth()->user()->name}}  <b class="caret"></b> </a>
                    <span class="dropdown-arrow"></span>
                    <ul class="dropdown-menu">
                        <li><a href="/logout">Log out</a></li>
                    </ul>
                </li>
            </ul>
            @if(false)
                <form class="navbar-form navbar-right" action="#" role="search">
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" id="navbarInput-01" type="search" placeholder="Search">
                            <span class="input-group-btn">
                                      <button type="submit" class="btn"><span class="fui-search"></span></button>
                                    </span>
                        </div>
                    </div>
                </form>
            @endif
        @endif
    </div><!-- /.navbar-collapse -->
</nav>