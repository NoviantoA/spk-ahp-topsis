<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">

        </span>
        <span class="app-brand-text demo menu-text fw-bold ms-2">AHP TOPSIS</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <li class="menu-item {{ request()->is('periode*') ? 'active' : '' }}">
        <a
          href="{{ route('periode') }}"
          class="menu-link ">
          <i class="menu-icon tf-icons bx bx-list-ul"></i>
          <div>Periode</div>
        </a>
      </li>
      <li class="menu-item {{ request()->is('kriteria*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-category"></i>
          <div>Kriteria</div>
          <div class="badge bg-label-primary rounded-pill ms-auto">2</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->is('all-kriteria*') ? 'active' : '' }}">
            <a href="{{ route('periode') }}" class="menu-link">
              <div>Kriteria</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('nilai-bobot-kriteria*') ? 'active' : '' }}">
            <a href="{{ route('periode') }}" class="menu-link">
              <div>Nilai Bobot Kriteria</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item {{ request()->is('alternatif*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-file"></i>
          <div>Alternatif</div>
          <div class="badge bg-label-primary rounded-pill ms-auto">2</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->is('all-alternatif*') ? 'active' : '' }}">
            <a href="{{ route('periode') }}" class="menu-link">
              <div>Alternatif</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('nilai-bobot-kriteria*') ? 'active' : '' }}">
            <a href="{{ route('periode') }}" class="menu-link">
              <div>Nilai Bobot Alternatif</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item {{ request()->is('perhitungan*') ? 'active' : '' }}">
        <a
          href="{{ route('periode') }}"
          class="menu-link ">
          <i class="menu-icon tf-icons bx bx-math"></i>
          <div>Perhitungan</div>
        </a>
      </li>
    </ul>
  </aside>
  <!-- / Menu -->
