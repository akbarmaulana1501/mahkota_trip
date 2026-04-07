<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
    <li class="nav-item">
      <a href="{{route('indexAdminUtama')}}" class="nav-link {{ request()->routeIs('indexAdminUtama') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{route('user.index')}}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p> Pengguna</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('jamaah.index') }}"
        class="nav-link {{ request()->routeIs('jamaah.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p> Jamaah</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('paket.index')}}" class="nav-link {{ request()->routeIs('paket.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tags"></i>
        <p> Manajemen Paket</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('log_aktifitas')}}" class="nav-link {{ request()->routeIs('log_aktifitas') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clock-rotate-left"></i>
        <p> Log Aktifitas</p>
      </a>
    </li>

    @php
    $pemasukanRoutes = ['pembayaran', 'investasi'];
    $isPemasukanActive = in_array(Route::currentRouteName(), $pemasukanRoutes);
    @endphp
    <li class="nav-item {{ $isPemasukanActive ? 'menu-open' : '' }}">
      <a href="#" class="nav-link {{ $isPemasukanActive ? 'active' : '' }}">
        <i class="nav-icon fas fa-circle-down"></i>
        <p>
          Pemasukan
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">2</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('pembayaran') }}" class="nav-link {{ request()->routeIs('pembayaran') ? 'active' : '' }}">
            <i class="nav-icon {{ request()->routeIs('pembayaran') ? 'far fa-dot-circle' : 'far fa-circle' }}"></i>
            <p>Pembayaran</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('investasi') }}" class="nav-link {{ request()->routeIs('investasi') ? 'active' : '' }}">
            <i class="nav-icon {{ request()->routeIs('investasi') ? 'far fa-dot-circle' : 'far fa-circle' }}"></i>
            <p>Invetasi</p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="{{ route('pengeluaran') }}" class="nav-link {{ request()->routeIs('pengeluaran') ? 'active' : '' }}">
        <i class="nav-icon fas fa-circle-up"></i>
        <p>Pengeluaran</p>
      </a>
    </li>

    @php
    $keberangkatanRoutes = ['keberangkatan.index', 'pembimbing.index', 'rombongan.index'];
    $isKeberangkatanActive = in_array(Route::currentRouteName(), $keberangkatanRoutes);
    @endphp

    <li class="nav-item {{ $isKeberangkatanActive ? 'menu-open' : '' }}">
      <a href="#" class="nav-link {{ $isKeberangkatanActive ? 'active' : '' }}">
        <i class="nav-icon fas fa-suitcase"></i>
        <p>
          Keberangkatan
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">3</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('keberangkatan.index') }}" class="nav-link {{ request()->routeIs('keberangkatan.*') ? 'active' : '' }}">
            <i class="nav-icon {{ request()->routeIs('keberangkatan.index') ? 'far fa-dot-circle' : 'far fa-circle' }}"></i>
            <p>Jamaah Berangkat</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('pembimbing.index') }}" class="nav-link {{ request()->routeIs('pembimbing.*') ? 'active' : '' }}">
            <i class="nav-icon {{ request()->routeIs('pembimbing.index') ? 'far fa-dot-circle' : 'far fa-circle' }}"></i>
            <p>Daftar Pembimbing</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('rombongan.index') }}" class="nav-link {{ request()->routeIs('rombongan.*') ? 'active' : '' }}">
            <i class="nav-icon {{ request()->routeIs('rombongan.index') ? 'far fa-dot-circle' : 'far fa-circle' }}"></i>
            <p>Daftar Rombongan</p>
          </a>
        </li>
      </ul>
    </li>

    @php
    $isLogistikActive = request()->routeIs('logistik.*') || request()->routeIs('ShowDistribusi');
    @endphp
    <li class="nav-item {{ $isLogistikActive ? 'menu-open' : '' }}">
      <a href="#" class="nav-link {{ $isLogistikActive ? 'active' : '' }}">
        <i class="nav-icon fas fa-list"></i>
        <p>
          Logistik
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">2</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('logistik.index') }}" class="nav-link {{ request()->routeIs('logistik.*') ? 'active' : '' }}">
            <i class="nav-icon {{ request()->routeIs('logistik.*') ? 'far fa-dot-circle' : 'far fa-circle' }}"></i>
            <p>Stok</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('ShowDistribusi') }}" class="nav-link {{ request()->routeIs('ShowDistribusi') ? 'active' : '' }}">
            <i class="nav-icon {{ request()->routeIs('ShowDistribusi') ? 'far fa-dot-circle' : 'far fa-circle' }}"></i>
            <p>Distribusi</p>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a href="{{route('VisaJamaah')}}" class="nav-link {{ request()->routeIs('VisaJamaah') ? 'active' : '' }}">
        <i class="nav-icon fas fa-passport"></i>
        <p> Visa</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{route('AsuransiJamaah')}}" class="nav-link {{ request()->routeIs('AsuransiJamaah') ? 'active' : '' }}">
        <i class="nav-icon fas fa-shield-alt"></i>
        <p> Asuransi</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{route('tiket.index')}}" class="nav-link {{ request()->routeIs('tiket.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-ticket-alt"></i>
        <p> Tiket</p>
      </a>
    </li>
    @if(auth()->user()->role === 'superadmin')
    <li class="nav-item">
      <a href="{{route('komisi_admin.index')}}" class="nav-link {{ request()->routeIs('komisi_admin.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-dollar-sign"></i>
        <p> Komisi</p>
      </a>
    </li>
    @endif


    <li class="nav-item">
      <a href="{{route('ManajemenKomentar')}}" class="nav-link {{ request()->routeIs('ManajemenKomentar') ? 'active' : '' }}">
        <i class="nav-icon fas fa-comment"></i>
        <p> Komentar</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('TampilLaporan')}}" class="nav-link {{ request()->routeIs('TampilLaporan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file"></i>
        <p> SISKOPATU</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
      </a>
    </li>
    @elseif(auth()->user()->role === 'marketing')
    <!-- marketing -->
    <li class="nav-item">
      <a href="{{route('dashMarketing')}}" class="nav-link {{ request()->routeIs('dashMarketing') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p> Dashboard</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('calonjamaah.index')}}" class="nav-link {{ request()->routeIs('calonjamaah.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p> Calon Jamaah</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('komisi.index')}}" class="nav-link {{ request()->routeIs('komisi.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-dollar-sign"></i>
        <p> Komisi</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
      </a>
    </li>
    @elseif(auth()->user()->role === 'superadmin')
    <li class="nav-item">
      <a href="{{route('dashSuperAdmin')}}" class="nav-link {{ request()->routeIs('dashSuperAdmin') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p> Dashboard</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="" class="nav-link {{ request()->routeIs('') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p> Akun </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('calonJamaah')}}" class="nav-link {{ request()->routeIs('calonJamaah') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p> Data Jamaah</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="" class="nav-link {{ request()->routeIs('') ? 'active' : '' }}">
        <i class="nav-icon fas fa-box"></i>
        <p> Data Logistik</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="" class="nav-link {{ request()->routeIs('') ? 'active' : '' }}">
        <i class="nav-icon fas fa-plane"></i>
        <p> Data Keberangkatan</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p> Logout</p>
      </a>
    </li>
    @elseif(auth()->user()->role === 'developer')
    <li class="nav-item">
      <a href="{{ route('dashboard.dev') }}" class="nav-link {{ request()->routeIs('dashboard.dev') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p> Dashboard</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('aktifitas.index') }}" class="nav-link {{ request()->routeIs('aktifitas.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-history"></i>
        <p> Log Aktivitas</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('error.index') }}" class="nav-link {{ request()->routeIs('error.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bug"></i>
        <p> Log Error</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="" class="nav-link {{ request()->routeIs('') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users-cog"></i>
        <p> Manajemen User</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="" class="nav-link {{ request()->routeIs('') ? 'active' : '' }}">
        <i class="nav-icon fas fa-cogs"></i>
        <p> Pengaturan Sistem</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="" class="nav-link {{ request()->routeIs('') ? 'active' : '' }}">
        <i class="nav-icon fas fa-database"></i>
        <p> Backup Database</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
      </a>
    </li>
    @elseif(Auth::guard('jamaah')->check())
    <li class="nav-item">
      <a href="{{route('dashJamaah')}}" class="nav-link {{ request()->routeIs('dashJamaah') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p> Dashboard</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('tagihanJamaah')}}" class="nav-link {{ request()->routeIs('tagihanJamaah') ? 'active' : '' }}">
        <i class="nav-icon fas fa-sack-dollar"></i>
        <p> Tabungan Saya </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('dokumenJamaah')}}" class="nav-link {{ request()->routeIs('dokumenJamaah') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file"></i>
        <p> Dokumen Saya</p>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a href="{{route('jadwalJamaah')}}" class="nav-link {{ request()->routeIs('jadwalJamaah') ? 'active' : '' }}">
        <i class="nav-icon fas fa-calendar"></i>
        <p> Jadwal Umrah</p>
      </a>
    </li> -->
    <!-- <li class="nav-item">
      <a href="" class="nav-link {{ request()->routeIs('') ? 'active' : '' }}">
        <i class="nav-icon fas fa-phone"></i>
        <p> Hubungi Admin</p>
      </a>
    </li> -->
    <li class="nav-item">
      <a href="{{ route('logout_jamaah') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p> Logout</p>
      </a>
    </li>
    @elseif(auth()->user()->role === 'logistik')
    <li class="nav-item">
      <a href="{{route('dashLogistik')}}" class="nav-link {{ request()->routeIs('dashLogistik') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p> Dashboard </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('ShowDistribusiLogis')}}" class="nav-link {{ request()->routeIs('ShowDistribusiLogis') ? 'active' : '' }}">
        <i class="nav-icon fas fa-hand-holding"></i>
        <p> Distribusi Logistik</p>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a href="" class="nav-link {{ request()->routeIs('') ? 'active' : '' }}">
        <i class="nav-icon fas fa-hourglass-half"></i>
        <p> Menunggu Validasi </p>
      </a>
    </li> -->
    <!-- <li class="nav-item">
      <a href="" class="nav-link {{ request()->routeIs('') ? 'active' : '' }}">
        <i class="nav-icon fas fa-history"></i>
        <p> Riwayat Penyerahan</p>
      </a>
    </li> -->
    <!-- <li class="nav-item">
      <a href="" class="nav-link {{ request()->routeIs('') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p> Data Jamaah</p>
      </a>
    </li> -->
    <li class="nav-item">
      <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p> Logout</p>
      </a>
    </li>
    @endif
  </ul>
</nav>