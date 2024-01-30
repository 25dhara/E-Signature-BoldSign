<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="dist/img/e-signLogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">E-Signature</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('sendDocumentForm') }}" class="nav-link">
                        <i class="nav-icon fas fa-paper-plane"></i>
                        <p>
                            Send Document
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('list-documents') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            List Documents
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('list-identity') }}" class="nav-link">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                            Identity
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('behalfList') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            BehalfOF List
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
