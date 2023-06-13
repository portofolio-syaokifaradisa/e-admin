<div class="pcoded-navigatio-lavel">Home</div>
<ul class="pcoded-item pcoded-left-item">
    <li class="{{ URLHelper::has('home') ? 'active' : "" }}">
        <a href="{{ route('home') }}">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Home</span>
        </a>
    </li>
</ul>

@if(in_array(Auth::user()->role, ['Admin', 'Superadmin']))
    <ul class="pcoded-item pcoded-left-item">
        <li class="pcoded-hasmenu {{ !URLHelper::has('report') && (URLHelper::has('pegawai') || URLHelper::has('desa') || URLHelper::has('service')) ? "pcoded-trigger" : "" }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="feather icon-server"></i></span>
                <span class="pcoded-mtext">Data Master</span>
            </a>
            <ul class="pcoded-submenu">
                @if(Auth::user()->role === "Superadmin")
                    <li class="{{ URLHelper::has('pegawai') ? 'active' : "" }}">
                        <a href="{{ route('pegawai.index') }}">
                            <span class="pcoded-mtext">Pegawai</span>
                        </a>
                    </li>
                @endif
                <li class="{{ URLHelper::has('desa') ? 'active' : "" }}">
                    <a href="{{ route('desa.index') }}">
                        <span class="pcoded-mtext">Desa/kelurahan</span>
                    </a>
                </li>
                <li class="{{ URLHelper::has('service') ? 'active' : "" }}">
                    <a href="{{ route('service.index') }}">
                        <span class="pcoded-mtext">Layanan</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    <ul class="pcoded-item pcoded-left-item">
        <li class="pcoded-hasmenu {{ !URLHelper::has('report') && (URLHelper::has('kependudukan') || URLHelper::has('pelayanan') || URLHelper::has('kehadiran') || URLHelper::has('dispensasi_nikah') || URLHelper::has('survey')) ? "pcoded-trigger" : "" }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                <span class="pcoded-mtext">Pencatatan</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ URLHelper::has('kehadiran') ? 'active' : "" }}">
                    <a href="{{ route('kehadiran.index') }}">
                        <span class="pcoded-mtext">Absensi Pegawai</span>
                    </a>
                </li>
                <li class="{{ URLHelper::has('kependudukan') ? 'active' : "" }}">
                    <a href="{{ route('kependudukan.index') }}">
                        <span class="pcoded-mtext">Kependudukan</span>
                    </a>
                </li>
                <li class="{{ URLHelper::has('pelayanan') && !URLHelper::has('report') ? 'active' : "" }}">
                    <a href="{{ route('pelayanan.index') }}">
                        <span class="pcoded-mtext">Pelayanan</span>
                    </a>
                </li>
                <li class="{{ URLHelper::has('dispensasi_nikah') ? 'active' : "" }}">
                    <a href="{{ route('dispensasi_nikah.index') }}">
                        <span class="pcoded-mtext">Dispensasi Nikah</span>
                    </a>
                </li>
                <li class="{{ URLHelper::has('survey') ? 'active' : "" }}">
                    <a href="{{ route('survey.index') }}">
                        <span class="pcoded-mtext">Survey</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    <ul class="pcoded-item pcoded-left-item">
        <li class="pcoded-hasmenu {{ URLHelper::has('report') ? "pcoded-trigger" : "" }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                <span class="pcoded-mtext">Laporan</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ URLHelper::has('pegawai') && URLHelper::has('report') ? 'active' : "" }}">
                    <a href="{{ route('report.pegawai') }}">
                        <span class="pcoded-mtext">Pegawai</span>
                    </a>
                </li>
                <li class="{{ URLHelper::has('absensi') && URLHelper::has('report')? 'active' : "" }}">
                    <a href="{{ route('report.absensi') }}">
                        <span class="pcoded-mtext">Absensi Pegawai</span>
                    </a>
                </li>
                <li class="{{ URLHelper::has('kependudukan') && URLHelper::has('report')? 'active' : "" }}">
                    <a href="{{ route('report.kependudukan') }}">
                        <span class="pcoded-mtext">Kependudukan</span>
                    </a>
                </li>
                <li class="{{ URLHelper::has('pelayanan') && URLHelper::has('report')? 'active' : "" }}">
                    <a href="{{ route('report.pelayanan') }}">
                        <span class="pcoded-mtext">Pelayanan</span>
                    </a>
                </li>
                <li class="{{ URLHelper::has('dispensasi') && URLHelper::has('report')? 'active' : "" }}">
                    <a href="{{ route('report.dispensasi') }}">
                        <span class="pcoded-mtext">Dispensasi Nikah</span>
                    </a>
                </li>
                <li class="{{ URLHelper::has('survey') && URLHelper::has('report') ? 'active' : "" }}">
                    <a href="{{ route('report.survey') }}">
                        <span class="pcoded-mtext">Survey</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
@endif